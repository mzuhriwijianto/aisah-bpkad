<!doctype html>
<html lang="en">
<head>
	
	<meta charset="UTF-8">
    <title>DATA PERALATAN & MESIN</title>
	
	    <style type="text/css">
        @page {
            margin: 10px;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        a {
            color: #000;
            text-decoration: none;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .invoice table {
            margin: 15px;
        }
        .invoice h3 {
            margin-left: 15px;
        }
        .information {
            background-color: #fff;
            color: #000;
			margin: 15px;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 5px;
        }
div.unstyledTable {
}
.divTable.unstyledTable .divTableCell, .divTable.unstyledTable .divTableHead {
}
/* DivTable.com */
.divTable{ display: table; }
.divTableRow { display: table-row; }
.divTableHeading { display: table-header-group;}
.divTableCell, .divTableHead { display: table-cell; padding: 5px 20px 5px 1px;}
.divTableCell2, .divTableHead { display: table-cell; padding: 1% 5% -1% 58% ;width: 60%;}
.divTableCell3, .divTableHead { display: table-cell; font-size: 6.5px; padding: 1% -62% -1% 58%;}
.divTableHeading { display: table-header-group;}
.divTableFoot { display: table-footer-group;}
.divTableBody { display: table-row-group;}

div.unstyledTable {
}
.divTable.unstyledTable .divTableCell, .divTable.unstyledTable .divTableHead {
  border: 0px solid #000;
}
.divTable.unstyledTable .divTableBody .divTableCell {
  font-size: 8px;
}

table.minimalistBlack {
  border: 0.3px solid #000000;
  width: 60%;
  text-align: left;
  border-collapse: collapse;
}
table.minimalistBlack td, table.minimalistBlack th {
  border: 0.3px 0.3px 0.3px 0.3px solid #000000;
  padding: 10px 4px;
}
table.minimalistBlack tbody td {
	border: 0.1px 0.1px 0.1px 0.1px solid #000000;
   font-size: 9px;
}
table.minimalistBlack thead {
  background: #FFFFFF;
  border: 0.1px 0.1px 0.1px 0.1px solid #000000;
}
table.minimalistBlack thead th {
  font-size: 9px;
  font-weight: bold;
  color: #000000;
  text-align: left;
  background-color: #ededed;
}
table.minimalistBlack tfoot td,table.minimalistBlack tfoot tr {
  border: 0.1px 0.1px 0.1px 0.1px solid #000000;
  font-size: 9px;
}
div.minimalistBlack {
  border: 0px solid #FFFFFF;
  background-color: #FFFFFF;
  width: 100%;
  text-align: left;
}
.divTable.minimalistBlack .divTableCell, .divTable.minimalistBlack .divTableHead {
  padding: 2px 4px;
}
.divTable.minimalistBlack .divTableBody .divTableCell {
  font-size: 8px;
}
.divTable.minimalistBlack .divTableRow:nth-child(even) {
  background: #FFFFFF;
}
.divTable.minimalistBlack .divTableCell:nth-child(even) {
  background: #FFFFFF;
}
.minimalistBlack .tableFootStyle {
  font-size: 12px;
}

#header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: #ededed; text-align: center; }
#footer {
   position:absolute;
   bottom:0;
   width:100%;
   height:60px;   /* Height of the footer */
}
#watermark {
	position: fixed;
	opacity: 0.2;
	background-image: url("https://drive.google.com/thumbnail?id=12KPV_2qCGrnYubEA5gRAI-ZwdQI3u_sq");
	background-repeat: repeat;
	/** 
		Set a position in the page for your image
		This should center it vertically
	**/
	top: 2cm;
	bottom: 2cm;
	left: 0.1cm;
	right: 0.1cm;

	/** Change image dimensions**/
	 width:  100%;
     height: 100%;

	/** Your watermark should be behind every content**/
	z-index:  -10000;
}


	</style>
</head>


<body>

<div id="watermark">
	 <!--<img src="https://drive.google.com/thumbnail?id=12KPV_2qCGrnYubEA5gRAI-ZwdQI3u_sq" />-->
</div>
<table style="width: 100%;">
	<tbody>
		<tr>
			<td style="width: 8%;text-align:center;">
				<!--<b style = "font-size: 20px;" ><img src="{{ public_path('la-assets\img\Logo.jpg') }}" alt="Logo" width="45" class="logo"/></b>-->
				<b style = "font-size: 20px;" ><img src="https://drive.google.com/thumbnail?id=1E9Gzlyi0RPb1-Vg6LDPM6i-O-UKGsuV8" alt="Logo" width="45" class="logo"/></b>
			</td>
			<td style="width: 50%;text-align:center;">
				<b style = "font-size: 20px;" > PEMERINTAH KABUPATEN BOJONEGORO</b>
				<br/>
				<b style = "font-size: 14px;">DATA PERALATAN & MESIN</b>
			</td>
			<td style="width: 10%;text-align:right;font-size: 7px;">
				
			</td>
		</tr>
	</tbody>

</table>
<hr/>
<div class="divTable unstyledTable">
<table class="minimalistBlack" style="width: 100%;">
	<tbody >
		<tr>
			<td><b>OPD</b></td><td style="text-align:center;"><b>:</b></td><td>{{ Module::userlogin()->dept_name }}</td>			
			<td><b>K I B</b></td><td style="text-align:center;"><b>:</b></td><td>PERALATAN DAN MESIN</td>			
			<td><b>TAHUN CETAK</b></td><td style="text-align:center;"><b>:</b></td><td>{{ date('Y') }}</td>			
			<td><b>WAKTU CETAK</b></td><td style="text-align:center;"><b>:</b></td><td>{{ date('d-m-Y') }}</td>			
		</tr>
	</tbody>

</table>
</div>
<div class="divTable unstyledTable">
	<table style="width: 100%;">
		<tbody>
			<tr>
				<td><b style = "font-size: 18px;">DAFTAR BARANG</b></td>
			</tr>
		</tbody>
	</table>
</div>
				@if(count($kibbitem) == 0 )
					<h3></h3>
				@else
				<div class="divTable unstyledTable">
						<table class="minimalistBlack" style="width: 100%;font-size: 9px;">
						<thead>
						<tr id = "header">
							<td style="text-align:center;" >No.</td>
							<td style="text-align:center;" >KD Barang</td>
							<td style="text-align:center;" >NO REG</td>					
							<td style="text-align:center;" >NAMA ASET</td>																													
							<td style="text-align:center;" >THN PEROLEHAN</td>																														
							<td style="text-align:center;" >TGL PEROLEHAN</td>																														
							<td style="text-align:center;" >MERK/TYPE</td>																												
							<td style="text-align:center;" >NO POLISI</td>																												
							<td style="text-align:center;" >NO RANGKA</td>																												
							<td style="text-align:center;" >NO MESIN</td>
							<td style="text-align:center;" >BAHAN</td>
							<td style="text-align:center;" >HARGA</td>																																																																																																																											
							<td style="text-align:center;" >KONDISI AWAL</td>																																																																																																																																																				
							<td style="text-align:center;" >KONDISI AKHIR</td>																																																																																																																																																																																																																																																																																																							
							<td style="text-align:center;" >KET</td>																																																																																																																																																				
							<td style="text-align:center;" >PEMEGANG BRG</td>																																																																																																																																																				
							<td style="text-align:center;" >GAMBAR</td>																																																																																																																																																				
						</tr>
						</thead>
						<tbody>
							@foreach ($kibbitem as $index =>$kibbsuserbrgs)
							<tr>
								<td style="text-align:center;">{{ $index + 1 }}</td>
								<td style="text-align:center;">{{ $kibbsuserbrgs->kd_barang }}</td>
								<td style="text-align:center;">{{ $kibbsuserbrgs->no_reg }}</td>
								<td style="text-align:center;">{{ $kibbsuserbrgs->Nm_Aset5 }}</td>
								<td style="text-align:center;">{{ $kibbsuserbrgs->thnperolehan }}</td>
								<td style="text-align:center;">{{ $kibbsuserbrgs->tgl_perolehan }}</td>
								<td style="text-align:center;">{{ $kibbsuserbrgs->merk }} - {{ $kibbsuserbrgs->type }}</td>
								<td style="text-align:center;">{{ $kibbsuserbrgs->nomor_polisi }}</td>
								<td style="text-align:center;font-size: 7px;">{{ $kibbsuserbrgs->nomor_rangka }}</td>
								<td style="text-align:center;font-size: 7px;">{{ $kibbsuserbrgs->nomor_mesin }}</td>								
								<td style="text-align:center;">{{ $kibbsuserbrgs->bahan }}</td>
								<td style="text-align:right;">{{ $kibbsuserbrgs->harga }}</td>
								<td style="text-align:center;">{{ $kibbsuserbrgs->kondisi }}</td>
								<td style="text-align:center;">{{ $kibbsuserbrgs->kondisi_akhir }}</td>
								<td style="text-align:center;">{{ $kibbsuserbrgs->pemegang_brg }}</td>												
								<td style="text-align:center;font-size: 7px;">{{ $kibbsuserbrgs->keterangan }}</td>
								<td style="text-align:center;">					
									@if($kibbsuserbrgs->imgname != '')									
										<img src="{{ public_path('storage/imgkib/Image/'.$kibbsuserbrgs->imgname) }}" alt="gambar" style="width:150px;height:120px;"/>						
									@else
									<i>no pic</i>
									@endif					
								</td>
							</tr>
							@endforeach	
						</tbody>
						<tfoot>
							<tr>
							
							<td colspan="6" align = "center"><b></B></td>								
							<td style="text-align:right;"><b></b></td>
							<td><b></b></td>
							<td><b></b></td>					
							<td><b></b></td>					
							<td><b></b></td>					
							<td><b></b></td>					
							<td><b></b></td>					
							</tr>
						</tfoot>													
						</table>
				</div>
				@endif
				<br/>
				<br/>
				<table style="width: 100%;">
					<tbody>
						<tr>
							<td style="width: 30%;text-align:left;">
								
							</td>
							<td style="width: 30%;text-align:center;">
							</td>
							<td style="width: 40%;text-align:center;font-size: 7px;">
								<b style = "font-size: 14px; text-align:center;"></b>
								<br>
								<br>
								<u><b style = "font-size: 14px; text-align:center;"></b></u>
								<br>
								<b style = "font-size: 14px; text-align:center;"></b>
							</td>
						</tr>
					</tbody>

				</table>
<div id="footer">
<table style="width: 100%;">
<hr/>
	<tbody>
		<tr>
			<td style="width: 10%;text-align:left;font-size: 7px;">
				<b>{{ Module::userlogin()->dept_name }}</b>
				<br/>
				<b>KABUPATEN BOJONEGORO</b>
				<br/>
				<b>Print at : {{ date('d-m-Y') }}</b>				
				<br/>
				<i>Url:</i>
				<i>{{ url(config('laraadmin.adminRoute')) }}</i>
			</td>
			<td style="width: 50%;text-align:center;">
			</td>
			<td style="width: 10%;text-align:right;font-size: 7px;">
				<b>BADAN PENGELOLAAN KEUANGAN DAN</b>
				<br/>
				<b>ASET DAERAH</b>
				<b>KABUPATEN BOJONEGORO</b>
				<br/>
				<i>Jl. P. Mastumapel No.01</i>
				<i>Bojonegoro</p>
				<i>Jawa Timur, Indonesia</i>
			</td>
			
		</tr>
	</tbody>

</table>
</div>
<!-- ************************************************************************** -->

</body>


</html>
