<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team AND Mike Branderhorst
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * File Uploading Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Uploads
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/file_uploading.html
 */
class CI_Upload {
	
	// user given variables
	var $upload_path	= "";
	var $allowed_types	= "";
	var $overwrite		= FALSE;
	var $max_size		= 0;
	var $max_width		= 0;
	var $max_height		= 0;
	var $max_filename	= 0;
	var $encrypt_name	= FALSE;
	var $remove_spaces	= TRUE;
	
	// system given variables
	var $file_temp		= "";
	var $file_name		= "";
	var $orig_name		= "";
	var $file_type		= "";
	var $file_size		= "";
	var $file_ext		= "";
	var $is_image		= FALSE;
	var $image_width	= '';
	var $image_height	= '';
	var $image_type		= '';
	var $image_size_str	= '';
	var $error_msg		= array();
	var $mimes			= array();
	var $xss_clean		= FALSE;
	var $temp_prefix	= "temp_file_";
	
	var $fields			= array();
	
	/**
	 * Constructor
	 *
	 * @access	public
	 */
	function CI_Upload($config = array())
	{
		if (count($config) > 0)
		{
			$this->initialize($config);
		}
		
		log_message('debug', "Upload Class Initialized");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Initialize preferences
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */	
	function initialize($config = array())
	{
		/*
		 * It can be one file or global config
		 * It can be global and or file specific config (override)
		 * Example global for most and specific for few
		 */
		
		$defaults = array(
			
			// user given variables
			'upload_path'		=> "",
			'allowed_types'		=> "",
			'overwrite'			=> FALSE,
			'max_size'			=> 0,
			'max_width'			=> 0,
			'max_height'		=> 0,
			'max_filename'		=> 0,
			'encrypt_name'		=> FALSE,
			'remove_spaces'		=> TRUE,
			
			// system given variables
			'file_temp'			=> "",
			'file_name'			=> "",
			'orig_name'			=> "",
			'file_type'			=> "",
			'file_size'			=> "",
			'file_ext'			=> "",
			'is_image'			=> FALSE,
			'image_width'		=> '',
			'image_height'		=> '',
			'image_type'		=> '',
			'image_size_str'	=> '',
			'error_msg'			=> array(),
			'mimes'				=> array(),
			'xss_clean'			=> FALSE,
			'temp_prefix'		=> "temp_file_"
		);	
		
		// global or single file
		foreach ($defaults as $key => $val)
		{
			if (isset($config[$key]))
			{
				$method = 'set_'.$key;
				if (method_exists($this, $method))
				{
					$this->$method($config[$key]);
				}
				else
				{
					$this->$key = $config[$key];
				}			
			}
			else
			{
				$this->$key = $val;
			}
		}
		
		// specific file config
		foreach ($_FILES as $field => $conf)
		{
			if (array_key_exists($field,$config))
			{
				foreach ($defaults as $key => $val)
				{
					if (isset($config[$field][$key]))
					{
						$method = 'set_'.$key;
						if (method_exists($this, $method))
						{
							$this->$method($config[$field][$key], $field);
						}
						else
						{
							$this->$field->$key = $config[$field][$key];
						}			
					}
					else
					{
						$this->$field->$key = $val;
					}
				}
			}
		}
		
		#echo "<pre>"; print_r($_FILES); print_r($this); echo "</pre>"; die;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Perform the file upload
	 *
	 * @access	public
	 * @param	string | array | csv
	 * @return	bool
	 */	
	function do_upload($fields = 'userfile')
	{
		$return = TRUE;
		
		// Make array of one or more input names
		if ( ! is_array($fields))
		{
			$fields = explode(',',$fields);
		}
		
		// This is for data()
		$this->fields = $fields;
		
		foreach ($fields as $key => $field)
		{
			// Does $field exists in $_FILES
			if ( ! isset($_FILES[$field]))
			{
				$this->set_error('upload_no_file_selected', $field);
				$return = FALSE;
				continue;
			}
			
			// Is the upload path valid?
			if ( ! $this->validate_upload_path($field))
			{
				// errors will already be set by validate_upload_path()
				$return = FALSE;
				continue;
			}
			
			// Is $field array of files?
			if (is_array(current($_FILES[$field])))
			{
				foreach (current($_FILES[$field]) as $id => $file_name)
				{
					if ( ! $this->is_uploaded_file($field, $id))
					{
						#$return = FALSE;
						continue;
					}
					
					$this->set_uploaded_data($field, $id);
					
					// Convert the file size to kilobytes
					if ($this->$field->file_size[$id] > 0)
					{
						$this->$field->file_size[$id] = round($this->$field->file_size[$id]/1024, 2);
					}
					
					// Is the file type allowed to be uploaded?
					if ( ! $this->is_allowed_filetype($field, $id))
					{
						$this->set_error('upload_invalid_filetype', $field, $id);
						#$return = FALSE;
						continue;
					}
					
					// Is the file size within the allowed maximum?
					if ( ! $this->is_allowed_filesize($field, $id))
					{
						$this->set_error('upload_invalid_filesize', $field, $id);
						#$return = FALSE;
						continue;
					}
				
					// Are the image dimensions within the allowed size?
					// Note: This can fail if the server has an open_basdir restriction.
					if ( ! $this->is_allowed_dimensions($field, $id))
					{
						$this->set_error('upload_invalid_dimensions', $field, $id);
						#$return = FALSE;
						continue;
					}
					
					// Sanitize the file name for security
					$this->$field->file_name[$id] = $this->clean_file_name($this->$field->file_name[$id]);
					
					// Truncate the file name if it's too long
					if (isset($this->$field->max_filename)) // $field specific
					{
						if ($this->$field->max_filename > 0)
						{
							$this->$field->file_name[$id] = $this->limit_filename_length($this->$field->file_name[$id], $this->$field->max_filename);
						}
					}
					else
					{
						if ($this->max_filename > 0)
						{
							$this->$field->file_name[$id] = $this->limit_filename_length($this->$field->file_name[$id], $this->max_filename);
						}
					}
					
					// Remove white spaces in the name
					if (isset($this->$field->remove_spaces) AND $this->$field->remove_spaces == TRUE) // $field specific
					{
						$this->$field->file_name[$id] = preg_replace("/\s+/", "_", $this->$field->file_name[$id]);
					}
					else if ($this->remove_spaces == TRUE)
					{
						$this->$field->file_name[$id] = preg_replace("/\s+/", "_", $this->$field->file_name[$id]);
					}
					
					if (isset($this->$field->upload_path)) // $field specific
					{
						$upload_path = $this->$field->upload_path;
					}
					else
					{
						$upload_path = $this->upload_path;
					}
					
					/*
					 * Validate the file name
					 * This function appends an number onto the end of
					 * the file if one with the same name already exists.
					 * If it returns false there was a problem.
					 */
					$this->$field->orig_name[$id] = $this->$field->file_name[$id];
					
					if (isset($this->$field->overwrite) AND $this->$field->overwrite == FALSE) // $field specific
					{
						$this->$field->file_name[$id] = $this->set_filename($upload_path, $this->$field->file_name[$id], $field, $id);
						
						if ($this->$field->file_name[$id] === FALSE)
						{
							#$return = FALSE;
							continue;
						}
					}
					else if ($this->overwrite == FALSE)
					{
						$this->$field->file_name[$id] = $this->set_filename($upload_path, $this->$field->file_name[$id], $field, $id);
						
						if ($this->$field->file_name[$id] === FALSE)
						{
							#$return = FALSE;
							continue;
						}
					}
					
					/*
					 * Move the file to the final destination
					 * To deal with different server configurations
					 * we'll attempt to use copy() first.  If that fails
					 * we'll use move_uploaded_file().  One of the two should
					 * reliably work in most environments
					 */
					if ( ! @copy($this->$field->file_temp[$id], $upload_path.$this->$field->file_name[$id]))
					{
						if ( ! @move_uploaded_file($this->$field->file_temp[$id], $upload_path.$this->$field->file_name[$id]))
						{
							$this->set_error('upload_destination_error', $field, $id);
							#$return = FALSE;
							continue;
						}
					}
					
					/*
					 * Run the file through the XSS hacking filter
					 * This helps prevent malicious code from being
					 * embedded within a file.  Scripts can easily
					 * be disguised as images or other file types.
					 */
					if (isset($this->$field->xss_clean) AND $this->$field->xss_clean == TRUE) // $field specific
					{
						$this->$field->do_xss_clean($field, $id);
					}
					else if ($this->xss_clean == TRUE)
					{
						$this->do_xss_clean($field, $id);
					}
					
					/*
					 * Set the finalized image dimensions
					 * This sets the image width/height (assuming the
					 * file was an image).  We use this information
					 * in the "data" function.
					 */
					$this->set_image_properties($upload_path.$this->$field->file_name[$id], $field, $id);
				}
			}
			else // no file input array just regular file input
			{
				if ( ! $this->is_uploaded_file($field))
				{
					$return = FALSE;
					continue;
				}
				
				$this->set_uploaded_data($field);
				
				// Convert the file size to kilobytes
				if ($this->$field->file_size > 0)
				{
					$this->$field->file_size = round($this->$field->file_size/1024, 2);
				}
				
				// Is the file type allowed to be uploaded?
				if ( ! $this->is_allowed_filetype($field))
				{
					$this->set_error('upload_invalid_filetype', $field);
					$return = FALSE;
					continue;
				}
				
				// Is the file size within the allowed maximum?
				if ( ! $this->is_allowed_filesize($field))
				{
					$this->set_error('upload_invalid_filesize', $field);
					$return = FALSE;
					continue;
				}
		
				// Are the image dimensions within the allowed size?
				// Note: This can fail if the server has an open_basdir restriction.
				if ( ! $this->is_allowed_dimensions($field))
				{
					$this->set_error('upload_invalid_dimensions', $field);
					$return = FALSE;
					continue;
				}
				
				// Sanitize the file name for security
				$this->$field->file_name = $this->clean_file_name($this->$field->file_name);
				
				// Truncate the file name if it's too long
				if (isset($this->$field->max_filename)) // $field specific
				{
					if ($this->$field->max_filename > 0)
					{
						$this->$field->file_name = $this->limit_filename_length($this->$field->file_name, $this->$field->max_filename);
					}
				}
				else
				{
					if ($this->max_filename > 0)
					{
						$this->$field->file_name[$field] = $this->limit_filename_length($this->$field->file_name, $this->max_filename);
					}
				}
				
				// Remove white spaces in the name
				if (isset($this->$field->remove_spaces) AND $this->$field->remove_spaces == TRUE) // $field specific
				{
					$this->$field->file_name = preg_replace("/\s+/", "_", $this->$field->file_name);
				}
				else if ($this->remove_spaces == TRUE)
				{
					$this->$field->file_name = preg_replace("/\s+/", "_", $this->$field->file_name);
				}
				
				if (isset($this->$field->upload_path)) // $field specific
				{
					$upload_path = $this->$field->upload_path;
				}
				else
				{
					$upload_path = $this->upload_path;
				}
				
				/*
				 * Validate the file name
				 * This function appends an number onto the end of
				 * the file if one with the same name already exists.
				 * If it returns false there was a problem.
				 */
				$this->$field->orig_name = $this->$field->file_name;
		
				if (isset($this->$field->overwrite) AND $this->$field->overwrite == FALSE) // $field specific
				{
					$this->$field->file_name = $this->set_filename($upload_path, $this->$field->file_name, $field);
					
					if ($this->$field->file_name === FALSE)
					{
						$return = FALSE;
						continue;
					}
				}
				else if ($this->overwrite == FALSE)
				{
					$this->$field->file_name = $this->set_filename($upload_path, $this->$field->file_name, $field);
					
					if ($this->$field->file_name === FALSE)
					{
						$return = FALSE;
						continue;
					}
				}
				
				/*
				 * Move the file to the final destination
				 * To deal with different server configurations
				 * we'll attempt to use copy() first.  If that fails
				 * we'll use move_uploaded_file().  One of the two should
				 * reliably work in most environments
				 */
				if ( ! @copy($this->$field->file_temp, $upload_path.$this->$field->file_name))
				{
					if ( ! @move_uploaded_file($this->$field->file_temp, $upload_path.$this->$field->file_name))
					{
						$this->set_error('upload_destination_error', $field);
						$return = FALSE;
						continue;
					}
				}
				
				/*
				 * Run the file through the XSS hacking filter
				 * This helps prevent malicious code from being
				 * embedded within a file.  Scripts can easily
				 * be disguised as images or other file types.
				 */
				if (isset($this->$field->xss_clean) AND $this->$field->xss_clean == TRUE) // $field specific
				{
					$this->$field->do_xss_clean($field);
				}
				if ($this->xss_clean == TRUE)
				{
					$this->do_xss_clean($field);
				}
				
				/*
				 * Set the finalized image dimensions
				 * This sets the image width/height (assuming the
				 * file was an image).  We use this information
				 * in the "data" function.
				 */
				$this->set_image_properties($upload_path.$this->$field->file_name, $field);
			}
		}
		
		#echo "<pre>"; print_r($this); echo "</pre>"; die;

		return $return;
	}

	function is_uploaded_file($field, $id = FALSE)
	{
		if ($id === FALSE)
		{
			$is_uploaded_file = is_uploaded_file($_FILES[$field]['tmp_name']);
		}
		else
		{
			$is_uploaded_file = is_uploaded_file($_FILES[$field]['tmp_name'][$id]);
		}
		
		// Was the file able to be uploaded? If not, determine the reason why.
		if ( ! $is_uploaded_file)
		{
			if ($id === FALSE)
			{
				$error = ( ! isset($_FILES[$field]['error'])) ? 4 : $_FILES[$field]['error'];
			}
			else
			{
				$error = ( ! isset($_FILES[$field]['error'][$id])) ? 4 : $_FILES[$field]['error'][$id];
			}
			
			switch($error)
			{
				case 1:	// UPLOAD_ERR_INI_SIZE
					$this->set_error('upload_file_exceeds_limit', $field);
					break;
				case 2: // UPLOAD_ERR_FORM_SIZE
					$this->set_error('upload_file_exceeds_form_limit', $field);
					break;
				case 3: // UPLOAD_ERR_PARTIAL
				   $this->set_error('upload_file_partial', $field);
					break;
				case 4: // UPLOAD_ERR_NO_FILE
				   $this->set_error('upload_no_file_selected', $field);
					break;
				case 6: // UPLOAD_ERR_NO_TMP_DIR
					$this->set_error('upload_no_temp_directory', $field);
					break;
				case 7: // UPLOAD_ERR_CANT_WRITE
					$this->set_error('upload_unable_to_write_file', $field);
					break;
				case 8: // UPLOAD_ERR_EXTENSION
					$this->set_error('upload_stopped_by_extension', $field);
					break;
				default: $this->set_error('upload_no_file_selected', $field);
					break;
			}

			return FALSE;
		}
		
		return TRUE;
	}
	
	function set_uploaded_data($field, $id = FALSE)
	{
		if ($id === FALSE)
		{
			// Set the uploaded data as class variables
			$this->$field->file_temp = $_FILES[$field]['tmp_name'];
			$this->$field->file_name = $this->_prep_filename($_FILES[$field]['name']);
			$this->$field->file_size = $_FILES[$field]['size'];
			$this->$field->file_type = preg_replace("/^(.+?);.*$/", "\\1", $_FILES[$field]['type']);
			$this->$field->file_type = strtolower($this->$field->file_type);
			$this->$field->file_ext	 = $this->get_extension($_FILES[$field]['name']);
		}
		else
		{
			// Set the uploaded data as class variables
			$this->$field->file_temp[$id] = $_FILES[$field]['tmp_name'][$id];
			$this->$field->file_name[$id] = $this->_prep_filename($_FILES[$field]['name'][$id]);
			$this->$field->file_size[$id] = $_FILES[$field]['size'][$id];
			$this->$field->file_type[$id] = preg_replace("/^(.+?);.*$/", "\\1", $_FILES[$field]['type'][$id]);
			$this->$field->file_type[$id] = strtolower($this->$field->file_type[$id]);
			$this->$field->file_ext[$id]  = $this->get_extension($_FILES[$field]['name'][$id]);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Finalized Data Array
	 *	
	 * Returns an associative array containing all of the information
	 * related to the upload, allowing the developer easy access in one array.
	 *
	 * @access	public
	 * @return	array
	 */	
	function data($fields = FALSE)
	{
		if ($fields == FALSE)
		{
			$fields = $this->fields;
		}
		
		// Make array of one or more input names
		if ( ! is_array($fields))
		{
			$fields = explode(',',$fields);
		}
		
		$data = array();
		
		foreach ($fields as $field)
		{
			$data[$field] = $this->$field;
			
			unset($data[$field]->file_temp);
			
			if (is_array(current($this->$field)))
			{
				foreach (current($this->$field) as $id => $value)
				{
					$data[$field]->file_path[$id] = (isset($this->$field->upload_path)) ? $this->$field->upload_path : $this->upload_path;
					$data[$field]->full_path[$id] = $data[$field]->file_path[$id].$data[$field]->file_name[$id];
					$data[$field]->raw_name[$id]  = str_replace($data[$field]->file_ext[$id], '', $data[$field]->file_name[$id]);
					$data[$field]->is_image[$id]  = $this->is_image($field, $id);
				}
			}
			else
			{
				$data[$field]->file_path = (isset($this->$field->upload_path)) ? $this->$field->upload_path : $this->upload_path;
				$data[$field]->full_path = $data[$field]->file_path.$data[$field]->file_name;
				$data[$field]->raw_name  = str_replace($data[$field]->file_ext, '', $data[$field]->file_name);
				$data[$field]->is_image  = $this->is_image($field);
			}
			
			// objects to arrays
			$data[$field] = get_object_vars($data[$field]);
		}
		
		// one field array
		if (count($data) == 1)
		{
			$data = $data[$field];
		}
		
		return $data;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set Upload Path
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */	
	function set_upload_path($path, $field = FALSE)
	{
		if ($field === FALSE)
		{
			// Make sure it has a trailing slash
			$this->upload_path = rtrim($path, '/').'/';
		}
		else
		{
			// Make sure it has a trailing slash
			$this->$field->upload_path = rtrim($path, '/').'/';
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set the file name
	 *
	 * This function takes a filename/path as input and looks for the
	 * existence of a file with the same name. If found, it will append a
	 * number to the end of the filename to avoid overwriting a pre-existing file.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	string
	 */	
	function set_filename($path, $filename, $field, $id = FALSE)
	{
		if ($id === FALSE)
		{
			$file_ext = $this->$field->file_ext;
		}
		else
		{
			$file_ext = $this->$field->file_ext[$id];
		}
		
		if (isset($this->$field->encrypt_name) AND $this->$field->encrypt_name == TRUE) // $field specific
		{		
			mt_srand();
			$filename = md5(uniqid(mt_rand())).$file_ext;	
		}
		else if ($this->encrypt_name == TRUE)
		{		
			mt_srand();
			$filename = md5(uniqid(mt_rand())).$file_ext;	
		}
		
		if ( ! file_exists($path.$filename))
		{
			return $filename;
		}
	
		$filename = str_replace($file_ext, '', $filename);
		
		$new_filename = '';
		for ($i = 1; $i < 100; $i++)
		{			
			if ( ! file_exists($path.$filename.$i.$file_ext))
			{
				$new_filename = $filename.$i.$file_ext;
				break;
			}
		}

		if ($new_filename == '')
		{
			$this->set_error('upload_bad_filename', $field, $id);
			return FALSE;
		}
		else
		{
			return $new_filename;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set Maximum File Size
	 *
	 * @access	public
	 * @param	integer
	 * @return	void
	 */	
	function set_max_filesize($n, $field = FALSE)
	{
		if ($field === FALSE)
		{
			$this->max_size = ((int) $n < 0) ? 0: (int) $n;
		}
		else
		{
			$this->$field->max_size = ((int) $n < 0) ? 0: (int) $n;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set Maximum File Name Length
	 *
	 * @access	public
	 * @param	integer
	 * @return	void
	 */	
	function set_max_filename($n, $field = FALSE)
	{
		if ($field === FALSE)
		{
			$this->max_filename = ((int) $n < 0) ? 0: (int) $n;
		}
		else
		{
			$this->$field->max_filename = ((int) $n < 0) ? 0: (int) $n;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set Maximum Image Width
	 *
	 * @access	public
	 * @param	integer
	 * @return	void
	 */	
	function set_max_width($n, $field = FALSE)
	{
		if ($field === FALSE)
		{
			$this->max_width = ((int) $n < 0) ? 0: (int) $n;
		}
		else
		{
			$this->$field->max_width = ((int) $n < 0) ? 0: (int) $n;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set Maximum Image Height
	 *
	 * @access	public
	 * @param	integer
	 * @return	void
	 */	
	function set_max_height($n, $field = FALSE)
	{
		if ($field === FALSE)
		{
			$this->max_height = ((int) $n < 0) ? 0: (int) $n;
		}
		else
		{
			$this->$field->max_height = ((int) $n < 0) ? 0: (int) $n;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set Allowed File Types
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */	
	function set_allowed_types($types, $field = FALSE)
	{
		if ($field === FALSE)
		{
			$this->allowed_types = explode('|', $types);
		}
		else
		{
			$this->$field->allowed_types = explode('|', $types);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set Image Properties
	 *
	 * Uses GD to determine the width/height/type of image
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */	
	function set_image_properties($path = '', $field, $id = FALSE)
	{
		if ( ! $this->is_image($field, $id))
		{
			return;
		}

		if (function_exists('getimagesize'))
		{
			if (FALSE !== ($D = @getimagesize($path)))
			{	
				$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');

				if ($id === FALSE)
				{
					$this->$field->image_width		= $D['0'];
					$this->$field->image_height		= $D['1'];
					$this->$field->image_type		= ( ! isset($types[$D['2']])) ? 'unknown' : $types[$D['2']];
					$this->$field->image_size_str	= $D['3'];  // string containing height and width
				}
				else
				{
					$this->$field->image_width[$id]		= $D['0'];
					$this->$field->image_height[$id]	= $D['1'];
					$this->$field->image_type[$id]		= ( ! isset($types[$D['2']])) ? 'unknown' : $types[$D['2']];
					$this->$field->image_size_str[$id]	= $D['3'];  // string containing height and width
				}
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set XSS Clean
	 *
	 * Enables the XSS flag so that the file that was uploaded
	 * will be run through the XSS filter.
	 *
	 * @access	public
	 * @param	bool
	 * @return	void
	 */
	function set_xss_clean($flag = FALSE, $field = FALSE)
	{
		if ($field == FALSE)
		{
			$this->xss_clean = ($flag == TRUE) ? TRUE : FALSE;
		}
		else
		{
			$this->$field->xss_clean = ($flag == TRUE) ? TRUE : FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Validate the image
	 *
	 * @access	public
	 * @return	bool
	 */	
	function is_image($field, $id = FALSE)
	{
		// IE will sometimes return odd mime-types during upload, so here we just standardize all
		// jpegs or pngs to the same file type.

		$png_mimes  = array('image/x-png');
		$jpeg_mimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');
		
		if ($id === FALSE)
		{
			if (in_array($this->$field->file_type, $png_mimes))
			{
				$this->$field->file_type = 'image/png';
			}
			
			if (in_array($this->$field->file_type, $jpeg_mimes))
			{
				$this->$field->file_type = 'image/jpeg';
			}
	
			$img_mimes = array(
								'image/gif',
								'image/jpeg',
								'image/png',
							   );
	
			return (in_array($this->$field->file_type, $img_mimes, TRUE)) ? TRUE : FALSE;
		}
		else
		{
			if (in_array($this->$field->file_type[$id], $png_mimes))
			{
				$this->$field->file_type[$id] = 'image/png';
			}
			
			if (in_array($this->$field->file_type[$id], $jpeg_mimes))
			{
				$this->$field->file_type[$id] = 'image/jpeg';
			}
	
			$img_mimes = array(
								'image/gif',
								'image/jpeg',
								'image/png',
							   );
	
			return (in_array($this->$field->file_type[$id], $img_mimes, TRUE)) ? TRUE : FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Verify that the filetype is allowed
	 *
	 * @access	public
	 * @return	bool
	 */	
	function is_allowed_filetype($field, $id = FALSE)
	{
		if (isset($this->$field->allowed_types)) // $field specific
		{
			$allowed_types = $this->$field->allowed_types;
		}
		else
		{
			$allowed_types = $this->allowed_types;
		}
		
		if (count($allowed_types) == 0 OR ! is_array($allowed_types))
		{
			$this->set_error('upload_no_file_types', $field);
			return FALSE;
		}
			
		$image_types = array('gif', 'jpg', 'jpeg', 'png', 'jpe');
		
		foreach ($allowed_types as $val)
		{
			$mime = $this->mimes_types(strtolower($val));

			if ($id === FALSE)
			{
				$file_temp = $this->$field->file_temp;
				$file_type = $this->$field->file_type;
			}
			else
			{
				$file_temp = $this->$field->file_temp[$id];
				$file_type = $this->$field->file_type[$id];
			}
			
			// Images get some additional checks
			if (in_array($val, $image_types))
			{
				if (getimagesize($file_temp) === FALSE)
				{
					return FALSE;
				}
			}
			
			if (is_array($mime))
			{
				if (in_array($file_type, $mime, TRUE))
				{
					return TRUE;
				}
			}
			else
			{
				if ($mime == $file_type)
				{
					return TRUE;
				}	
			}
			
			unset($allowed_types);
			unset($file_temp);
			unset($file_type);
		}	
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Verify that the file is within the allowed size
	 *
	 * @access	public
	 * @return	bool
	 */	
	function is_allowed_filesize($field, $id = FALSE)
	{
		if (isset($this->$field->max_size)) // $field specific
		{
			$max_size = $this->$field->max_size;
		}
		else
		{
			$max_size = $this->max_size;
		}
		
		if ($id === FALSE)
		{
			$file_size = $this->$field->file_size;
		}
		else
		{
			$file_size = $this->$field->file_size[$id];
		}
		
		if ($max_size != 0  AND  $file_size > $max_size)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Verify that the image is within the allowed width/height
	 *
	 * @access	public
	 * @return	bool
	 */	
	function is_allowed_dimensions($field, $id = FALSE)
	{
		if ( ! $this->is_image($field, $id))
		{
			return TRUE;
		}
		
		if (isset($this->$field->max_width)) // $field specific
		{
			$max_width = $this->$field->max_width;
		}
		else
		{
			$max_width = $this->max_width;
		}
		
		if (isset($this->$field->max_height)) // $field specific
		{
			$max_height = $this->$field->max_height;
		}
		else
		{
			$max_height = $this->max_height;
		}
		
		if (function_exists('getimagesize'))
		{
			if ($id === FALSE)
			{
				$D = @getimagesize($this->$field->file_temp);
			}
			else
			{
				$D = @getimagesize($this->$field->file_temp[$id]);
			}

			if ($max_width > 0 AND $D['0'] > $max_width)
			{
				return FALSE;
			}

			if ($max_height > 0 AND $D['1'] > $max_height)
			{
				return FALSE;
			}

			return TRUE;
		}
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Validate Upload Path
	 *
	 * Verifies that it is a valid upload path with proper permissions.
	 *
	 *
	 * @access	public
	 * @return	bool
	 */	
	function validate_upload_path($field)
	{
		if (isset($this->$field->upload_path)) // $field specific
		{
			if ($this->$field->upload_path == '')
			{
				$this->set_error('upload_no_filepath', $field);
				return FALSE;
			}
			
			if (function_exists('realpath') AND @realpath($this->$field->upload_path) !== FALSE)
			{
				$this->$field->upload_path = str_replace("\\", "/", realpath($this->$field->upload_path));
			}
	
			if ( ! @is_dir($this->$field->upload_path))
			{
				$this->set_error('upload_no_filepath', $field);
				return FALSE;
			}
	
			if ( ! is_really_writable($this->$field->upload_path))
			{
				$this->set_error('upload_not_writable', $field);
				return FALSE;
			}
	
			$this->$field->upload_path = preg_replace("/(.+?)\/*$/", "\\1/",  $this->$field->upload_path);
			return TRUE;
		}
		else
		{
			if ($this->upload_path == '')
			{
				$this->set_error('upload_no_filepath', $field);
				return FALSE;
			}
			
			if (function_exists('realpath') AND @realpath($this->upload_path) !== FALSE)
			{
				$this->upload_path = str_replace("\\", "/", realpath($this->upload_path));
			}
	
			if ( ! @is_dir($this->upload_path))
			{
				$this->set_error('upload_no_filepath', $field);
				return FALSE;
			}
	
			if ( ! is_really_writable($this->upload_path))
			{
				$this->set_error('upload_not_writable', $field);
				return FALSE;
			}
	
			$this->upload_path = preg_replace("/(.+?)\/*$/", "\\1/",  $this->upload_path);
			return TRUE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Extract the file extension
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */	
	function get_extension($filename)
	{
		$x = explode('.', $filename);
		return '.'.end($x);
	}	
	
	// --------------------------------------------------------------------
	
	/**
	 * Clean the file name for security
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */		
	function clean_file_name($filename)
	{
		$bad = array(
						"<!--",
						"-->",
						"'",
						"<",
						">",
						'"',
						'&',
						'$',
						'=',
						';',
						'?',
						'/',
						"%20",
						"%22",
						"%3c",		// <
						"%253c", 	// <
						"%3e", 		// >
						"%0e", 		// >
						"%28", 		// (
						"%29", 		// )
						"%2528", 	// (
						"%26", 		// &
						"%24", 		// $
						"%3f", 		// ?
						"%3b", 		// ;
						"%3d"		// =
					);
					
		$filename = str_replace($bad, '', $filename);

		return stripslashes($filename);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Limit the File Name Length
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */		
	function limit_filename_length($filename, $length)
	{
		if (strlen($filename) < $length)
		{
			return $filename;
		}
	
		$ext = '';
		if (strpos($filename, '.') !== FALSE)
		{
			$parts		= explode('.', $filename);
			$ext		= '.'.array_pop($parts);
			$filename	= implode('.', $parts);
		}
	
		return substr($filename, 0, ($length - strlen($ext))).$ext;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Runs the file through the XSS clean function
	 *
	 * This prevents people from embedding malicious code in their files.
	 * I'm not sure that it won't negatively affect certain files in unexpected ways,
	 * but so far I haven't found that it causes trouble.
	 *
	 * @access	public
	 * @return	void
	 */	
	function do_xss_clean($field, $id = FALSE)
	{		
		if (isset($this->$field->upload_path)) // $field specific
		{
			$upload_path = $this->$field->upload_path;
		}
		else
		{
			$upload_path = $this->upload_path;
		}
		
		if ($id === FALSE)
		{
			$file = $upload_path.$this->$field->file_name;
		}
		else
		{
			$file = $upload_path.$this->$field->file_name[$id];
		}
			
		if (filesize($file) == 0)
		{
			return FALSE;
		}

		if (($data = @file_get_contents($file)) === FALSE)
		{
			return FALSE;
		}
		
		if ( ! $fp = @fopen($file, FOPEN_READ_WRITE))
		{
			return FALSE;
		}
		
		$CI =& get_instance();	
		$data = $CI->input->xss_clean($data);
		
		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set an error message
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */	
	function set_error($msg, $field = FALSE, $id = FALSE)
	{
		$CI =& get_instance();	
		$CI->lang->load('upload');
		
		if ($id === FALSE)
		{	
			if (is_array($msg))
			{
				foreach ($msg as $val)
				{
					$msg = ($CI->lang->line($val) == FALSE) ? $val : $CI->lang->line($val);				
					$this->error_msg[] = $msg;
					log_message('error', $msg);
				}		
			}
			else
			{
				$msg = ($CI->lang->line($msg) == FALSE) ? $msg : $CI->lang->line($msg);
				$this->error_msg[] = $msg;
				log_message('error', $msg);
			}
		}
		else
		{
			if (is_array($msg))
			{
				foreach ($msg as $val)
				{
					$msg = ($CI->lang->line($val) == FALSE) ? $val : $CI->lang->line($val);				
					$this->error_msg[$id][] = $msg;
					log_message('error', $msg);
				}		
			}
			else
			{
				$msg = ($CI->lang->line($msg) == FALSE) ? $msg : $CI->lang->line($msg);
				$this->error_msg[$id][] = $msg;
				log_message('error', $msg);
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Display the error message
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	string
	 */	
	function display_errors($open = '<p>', $close = '</p>')
	{
		$str = '';
		foreach ($this->error_msg as $val)
		{
			if (is_array($val))
			{
				foreach ($val as $val2)
				{
					$str .= $open.$val2.$close;
				}
			}
			else
			{
				$str .= $open.$val.$close;
			}
		}
	
		return $str;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * List of Mime Types
	 *
	 * This is a list of mime types.  We use it to validate
	 * the "allowed types" set by the developer
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */	
	function mimes_types($mime)
	{
		global $mimes;
	
		if (count($this->mimes) == 0)
		{
			if (@require_once(APPPATH.'config/mimes'.EXT))
			{
				$this->mimes = $mimes;
				unset($mimes);
			}
		}
	
		return ( ! isset($this->mimes[$mime])) ? FALSE : $this->mimes[$mime];
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Prep Filename
	 *
	 * Prevents possible script execution from Apache's handling of files multiple extensions
	 * http://httpd.apache.org/docs/1.3/mod/mod_mime.html#multipleext
	 *
	 * @access	private
	 * @param	string
	 * @return	string
	 */
	function _prep_filename($filename)
	{
		if (strpos($filename, '.') === FALSE)
		{
			return $filename;
		}
		
		$parts		= explode('.', $filename);
		$ext		= array_pop($parts);
		$filename	= array_shift($parts);
				
		foreach ($parts as $part)
		{
			if ($this->mimes_types(strtolower($part)) === FALSE)
			{
				$filename .= '.'.$part.'_';
			}
			else
			{
				$filename .= '.'.$part;
			}
		}
		
		$filename .= '.'.$ext;
		
		return $filename;
	}
	
	// --------------------------------------------------------------------

}
// END Upload Class

/* End of file Upload.php */
/* Location: ./system/libraries/Upload.php */