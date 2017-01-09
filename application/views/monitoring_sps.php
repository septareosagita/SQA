
    <div class="clear"></div>

<div class="columns">
    <div class="column grid_2 first">
        <table class="data">
            <tr>
                <td colspan="3"><strong>STATUS D/U</strong></td>
            </tr>
            <tr>
                <th>Target</th>
                <th>Today</th>
                <th>Current Month</th>
            </tr>
            <tr>
                <td style="text-align:center"><?= $du_target;?></td>
                <td style="text-align:center">
                    <?php if ($u>=$du_target): ?>
                    <blink><span style="color: #ff0000"><?= ($u==null||$u=='')?0:$u;?></span></blink>
                    <?php else: ?>
                    <?= ($u==null||$u=='')?0:$u;?>
                    <?php endif; ?>
                </td>
                <td style="text-align:center">
                    <?php if ($M >= $du_target): ?>
                    <blink><span style="color: #ff0000"><?= ($M==null||$M=='')?0:$M;?></span></blink>
                    <?php else: ?>
                    <?= ($M==null||$M=='')?0:$M;?>
                    <?php endif; ?>
                </td>
            </tr>

        </table>
    </div>
    <div class="column grid_6">
        <table class="data" width="100%">
            <tr>
                <td colspan="21"><strong>STATUS PROBLEM SHEET (MONTHLY DATA)</strong></td>
            </tr>
            <tr>
                <th rowspan="2">&nbsp;</th>
               
                <?php foreach ($sn as $z): 
                		$shop = $z->SHOP_NM; ?>
                        <th colspan="2"><?= $shop ?></th>
                      <?php endforeach; ?>
            </tr>
            <tr>
              <?php foreach ($sn as $z): ?>
                       <td style="text-align:center"><?= strtoupper(date("M",strtotime("-1 month")));?></td>
                <td style="text-align:center"><?= strtoupper(date("M"));?></td>
                      <?php endforeach; ?>
                
            </tr>
            <tr>            
                  
                <th>ISSUE</th>
            	<?php 
				   $blnkrgsatu = strtoupper(date("n",strtotime("-1 month")));
				   $bln = strtoupper(date("n"));
				   foreach ($sn as $z): 
				   
				  	 $z_sn = $z->SHOP_NM ?>
	                <td style="text-align:center">
                	
                    	<?php foreach ($SUM_MONTH as $r): 
							if (($r->SHOP_NM == $z_sn) && ($r->MONTH == $blnkrgsatu) && ($r->SUM_TYPE == 'S')):
								echo $r->NUM_PS_MONTHLY;
							endif;
							endforeach;
						?>
					</td>
                 
        	        <td style="text-align:center">
            			
                        <?php $temp=0; foreach ($SUM_MONTH as $r): 
							if (($r->SHOP_NM == $z_sn) && ($r->MONTH == $bln) && ($r->SUM_TYPE == 'S')):
									echo $r->NUM_PS_MONTHLY;									
							endif;
							endforeach;
						?>
                    
	                </td> 
                <?php endforeach; ?>     
            </tr>
            <tr>
                <th>REPLY</th>
            <?php 
				   $blnkrgsatu = strtoupper(date("n",strtotime("-1 month")));
				   $bln = strtoupper(date("n"));
				   foreach ($sn as $z): 
				   
				  	 $z_sn = $z->SHOP_NM ?>
	                <td style="text-align:center">
                	
                    	<?php foreach ($SUM_MONTH as $r): 
							if (($r->SHOP_NM == $z_sn) && ($r->MONTH == $blnkrgsatu) && ($r->SUM_TYPE == 'R')):
								echo $r->NUM_PS_MONTHLY;
							endif;
							endforeach;
						?>
					</td>
                 
        	        <td style="text-align:center">
            			
                        <?php $temp=0; foreach ($SUM_MONTH as $r): 
							if (($r->SHOP_NM == $z_sn) && ($r->MONTH == $bln) && ($r->SUM_TYPE == 'R')):
									echo $r->NUM_PS_MONTHLY;									
							endif;
							endforeach;
						?>
                    
	                </td> 
                <?php endforeach; ?>     
            </tr>
            <tr>
                <th>UNDER INVEST</th>
                  <?php 
				   $blnkrgsatu = strtoupper(date("n",strtotime("-1 month")));
				   $bln = strtoupper(date("n"));
				   foreach ($sn as $z): 
				   
				  	 $z_sn = $z->SHOP_NM ?>
	                <td style="text-align:center">
                	
                    	<?php foreach ($SUM_MONTH as $r): 
							if (($r->SHOP_NM == $z_sn) && ($r->MONTH == $blnkrgsatu) && ($r->SUM_TYPE == 'U')):
								echo $r->NUM_PS_MONTHLY;
							endif;
							endforeach;
						?>
				<td style="text-align:center">
            			
                        <?php $temp=0; foreach ($SUM_MONTH as $r): 
							if (($r->SHOP_NM == $z_sn) && ($r->MONTH == $bln) && ($r->SUM_TYPE == 'U')):
									echo $r->NUM_PS_MONTHLY;									
							endif;
							endforeach;
						?>
                    
	                </td>
				<?php endforeach; ?>  
            </tr>
            <tr>
                <th>DELAY</th>
               <?php 
				   $blnkrgsatu = strtoupper(date("n",strtotime("-1 month")));
				   $bln = strtoupper(date("n"));
				   foreach ($sn as $z): 
				   
				  	 $z_sn = $z->SHOP_NM ?>
	                <td style="text-align:center">
                	
                    	<?php foreach ($SUM_MONTH as $r): 
							if (($r->SHOP_NM == $z_sn) && ($r->MONTH == $blnkrgsatu) && ($r->SUM_TYPE == 'D')):
								echo $r->NUM_PS_MONTHLY;
							endif;
							endforeach;
						?>
				<td style="text-align:center">
            			
                        <?php $temp=0; foreach ($SUM_MONTH as $r): 
							if (($r->SHOP_NM == $z_sn) && ($r->MONTH == $bln) && ($r->SUM_TYPE == 'D')):
									echo $r->NUM_PS_MONTHLY;									
							endif;
							endforeach;
						?>
                    
	                </td>
				<?php endforeach; ?>  
            </tr>
            <tr>
                <th>CLOSED</th>
               <?php 
				   $blnkrgsatu = strtoupper(date("n",strtotime("-1 month")));
				   $bln = strtoupper(date("n"));
				   foreach ($sn as $z): 
				   
				  	 $z_sn = $z->SHOP_NM ?>
	                <td style="text-align:center">
                	
                    	<?php foreach ($SUM_MONTH as $r): 
							if (($r->SHOP_NM == $z_sn) && ($r->MONTH == $blnkrgsatu) && ($r->SUM_TYPE == 'C')):
								echo $r->NUM_PS_MONTHLY;
							endif;
							endforeach;
						?>
				<td style="text-align:center">
            			
                        <?php $temp=0; foreach ($SUM_MONTH as $r): 
							if (($r->SHOP_NM == $z_sn) && ($r->MONTH == $bln) && ($r->SUM_TYPE == 'C')):
									echo $r->NUM_PS_MONTHLY;									
							endif;
							endforeach;
						?>
                    
	                </td>
				<?php endforeach; ?>   
            </tr>
        </table>
  <br/><br/>
    </div>
</div>
