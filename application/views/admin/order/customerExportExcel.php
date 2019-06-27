<?php
header("Content-type: application/octet-stream");
//header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Renters_".date('m-d-Y').".xls");
header("Pragma: no-cache");
header("Expires: 0");
$this->load->model('user_model');


/*
<th>Transaction ID</th>		 
<td style="text-align:left">'.ucfirst($myrow[paypal_transaction_id]).'</td>
*/

?>
<?php
$XML .= '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">'. date('Y-m-d'). '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">'.$this->config->item('site_title').' Finance '.$status.' List</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';	
		
$XML .= '<table border="1">
	<tr>
			<th>S no</th>
			<th>User Email</th> 
			<th>Payment Date</th>
			<th>Booking No</th>
			<th>Total</th>
			<th>Payment Type</th>
			<th>Status</th>
    </tr>';
$sno = 1;
foreach($getCustomerDetails as $myrow) {

     $bookedstatus = ($myrow[status]=="Pending")?"Failed":$myrow[status];
     $ptype = ($myrow[payment_type]=="Credit Cart")?"Credit Card":$myrow[payment_type]; 			
	$XML .='<tr>
    	<td style="text-align:left">'.$sno.'</td>
		<td style="text-align:left">'.ucfirst($myrow[email]).'</td>
		<td style="text-align:left">'.date('m-d-Y',strtotime($myrow[created])).'</td>
		<td style="text-align:left">'.ucfirst($myrow[bookingno]).'</td>
        <td style="text-align:left">'.$myrow['total'].'</td>
        <td style="text-align:left">'.ucfirst($myrow[payment_type]).'</td>
        <td style="text-align:left">'.$bookedstatus.'</td>
    </tr>';
	$sno=$sno+1;


}
	$XML .='</table>';	
echo $XML;


?>
                                                               