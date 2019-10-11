
<?php
use backend\models\Admin;
$this->title = 'Manage Common Amenities';
$this->params['subtitle'] = 'Manage Common Amenities';
$this->params['breadcrumbs'][]= '<ol class="breadcrumb">
<li class=""><a href="index.html">Home</a></li>
<li class="active"><a href="index.html">Dashboard</a></li>
</ol>';
?>

<?php

	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Data Tables</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">
					<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Id</th>
								<th>Amenity Name</th>
								<th>Amenity Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
						$i = 1;
						foreach($amenities as $amenity)
						{
							echo '<tr class="odd gradeX">
							<td>'.$i.'</td>
							<td>'.$amenity->name.'</td>
							<td>'.$amenity->description.'</td>
							<td><button class="btn btn-info"><i class="fa fa-pencil"></i></button></td>
							</tr>';
							$i++;
						}
						/*$models = new Admin();
						foreach($userdatas as $users)
						{
							$datas = $models->getUserinvites($users->id);
							$userid = $users->id;
							echo '<tr class="odd gradeX" id="usr_'.$userid.'">
								<td>'.$users->firstname.'</td>
								<td>'.$users->state.'</td>
								<td>'.count($datas).'</td>
								<td>'.$users->credit_total.'</td>
								<td><input type="button" class="btn btn-success" value="Block" onclick="changeuserstatus(\'block\','.$userid.')"></td>
								<td><input type="button" class="btn btn-info" value="View" onclick="view_user('.$userid.')"></td>
							</tr>';
						}*/
						echo '</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>';
	?>
<div class="invoice-popup-overlay">
	<div class="invoice-popup">
		<div>
			<button class="btn btn-danger pop-close" style="float: right;">Close</button>
			<div id="userdetails" class="popupdiv"></div>
			<div id="messagedetails" class="popupdiv">
				<div class="leftdiv">Message: </div>
				<div class="rightdiv"><textarea rows="5" cols="20" id="messagecont"></textarea></div>
				<input type="hidden" id="cuserid">
				<input type="button" value="Send" class="btn btn-primary" onclick="sendmessage()">
				<div class="has-success" id="succmsg" style="display: none;">
					<p class="help-block">
						<i class="fa fa-check"></i>
						Message sent successfully
					</p>
				</div>
			</div>
		</div>
	</div>
</div>


