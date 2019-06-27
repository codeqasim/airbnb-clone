<?php
header("Content-type: application/octet-stream");
//header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Receivable - ".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");
$this->load->model('order_model');




?>
<?php
$XML .= '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">'. date('Y-m-d'). '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">'.$this->config->item('site_title').' Account Receivable List</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';	
		
$XML .= '<table border="1">
	<tr>
    	<th>S No</th>
		<th>Date</th>
		<th>Booking No</th>
        <th>Property ID</th>		
		<th>Host Email</th>
		<th>Total Amount</th>
		<th>Guest Service Fee</th>
		<th>Host Service Fee</th>
		<th>Net Profit</th>
		<th>Amount to Host</th>
		<th>Account Name</th>
		<th>Account No</th>
		<th>Bank Name</th>
		<th>Bank Country</th>
		<th>Swift Code</th>
    </tr>';
$sno = 1;
foreach ($newbookingList->result() as $row){
    $hostemail = $this->account_model->get_all_details(USERS,array('id'=>$row->renter_id));
	$hostemailId = $hostemail->row()->email;
	$totalAmount = $row->totalAmt;;
							
	if($guest_tax_type == 'flat'){
				$gCommision = $guest_tax_value;
	}else{
			$gCommision = number_format(($totalAmount*$guest_tax_value)/100,2);
	}

	if($host_tax_type == 'flat'){
				$hCommision = $host_tax_value;
	}else{
			$hCommision = number_format(($totalAmount*$host_tax_value)/100,2);
	}
	
	$profit = $gCommision+$hCommision;

	$toHost = $row->totalAmt-$gCommision;
		
	$XML .='<tr>
    	<td style="text-align:left">'.$sno.'</td>
		<td style="text-align:left">'.date('d-m-Y',strtotime($row->dateAdded)).'</td>
        <td style="text-align:left">'.$row->Bookingno.'</td>
        <td style="text-align:left">'.$row->prd_id.'</td>
        <td style="text-align:left">'.$hostemailId.'</td>
		<td style="text-align:left">'.$row->totalAmt.'</td>
		<td style="text-align:left">'.$gCommision.'</td>
		<td style="text-align:left">'.$hCommision.'</td>
        <td style="text-align:left">'.$profit.'</td>
        <td style="text-align:left">'.$toHost.'</td>
        <td style="text-align:left">'.$row->accname.'</td>
        <td style="text-align:left">'.$row->bank_no.'</td>
        <td style="text-align:left">'.$row->bank_name.'</td>
        <td style="text-align:left">'.$row->Acccountry.'</td>
        <td style="text-align:left">'.$row->swiftcode.'</td>
    </tr>';
	$sno=$sno+1;

}
	$XML .='</table>';	
echo $XML;


?>
                                                               