<!doctype html>
<html lang="en">
<head>
	
	<meta charset="UTF-8">
    <title>LABEL</title>
	
	    <style type="text/css">
@page { size: 10cm 10cm protrait; margin: 2px 2px 0px 1px;}

caption {
	font-size: 5px;
}
table.minimalistBlack {
  border: 1px solid #000000;
  text-align: left;
}
table.minimalistBlack tr {
  padding: 0.2px 0.2px 0.2px 0.5px;
}
table.minimalistBlack td, table.minimalistBlack th {
  padding: 0.2px 0.2px 0.2px 0.5px;
}
table.minimalistBlack tbody td {
  font-size: 10.5px;
}
table.minimalistBlack thead {
  background: #FFFFFF;
  border: 0px 0.1px 0px 0px solid #000000;
}

table.minimalistBlacks {
  border: 0px solid #000000;
  text-align: left;
}
table.minimalistBlacks tr {
  padding: 0.2px 0.2px 0.2px 0.5px;
  margin: 0.2px 0.2px 0.2px 0.5px;
}
table.minimalistBlacks td, table.minimalistBlack th {
  padding: 0.2px 0.2px 0.2px 0.5px;
  margin: 0.2px 0.2px 0.2px 0.5px;
}
table.minimalistBlacks tbody td {
  font-size: 10px;
}
table.minimalistBlacks thead {
  background: #FFFFFF;
  border: 0px 0.1px 0px 0px solid #000000;
}


div.minimalistBlack {
  border: 0px solid #FFFFFF;
  background-color: #FFFFFF;
  width: 100%;
  text-align: left;
}
.divTable.divTableCell, .divTable.minimalistBlack .divTableHead {
  padding: 0.1px 0.1px;
}
.divTable.divTableBody .divTableCell {
  
  font-size: 9px;
}
.divTable.divTableRow:nth-child(even) {
	
  background: #FFFFFF;
}
.divTable.divTableCell:nth-child(even) {
  background: #FFFFFF;
}
.minimalistBlack .tableFootStyle {
  font-size: 0.2px;
}
/* DivTable.com */
.divTable{ display: table; }
.divTableRow { display: table-row; }
.divTableHeading { display: table-header-group;}
.divTableCell, .divTableHead { display: table-cell;}
.divTableHeading { display: table-header-group;}
.divTableFoot { display: table-footer-group;}
.divTableBody { display: table-row-group;}

div.unstyledTable {
	border: 0px 1px 0px 0px solid #000000;
}
.divTable.unstyledTable .divTableCell, .divTable.unstyledTable .divTableHead {
  padding:15px;
  border: 0.2px solid #000;
}
.divTable.unstyledTable .divTableBody .divTableCell {
  font-size: 0.2px;
}
		</style>
</head>


<body>

<table class="minimalistBlack" style="width: 100%;">
	<tbody>	
		@foreach ($kibbitem as $kibbitems)
		@php
			
			$barcode = "http://10.0.8.12:8000/check_kibb/".$kibbitems->idpemda
		@endphp
		<tr style="width: 100%;border: 1px solid #000000;">
			<td colspan="4" style="text-align:center;font-size: 15px;">
			<b>PEMERINTAH KABUPATEN BOJONEGORO</b>
			</td>
		</tr>
		<tr style="width: 100%;" align = "center">		
			<td colspan="4" align='center' style="text-align:center; border: 1px solid #000000;padding:0px;">
					<img src="data:image/png;base64,{{DNS2D::getBarcodePNG($barcode, 'QRCODE',4,4)}}" alt="barcode" />
			</td>				
		</tr>
		
		<tbody>
			<tr><td colspan = "4" style="width: 100%;border: 1px solid #000000;"><b>INFORMASI</b></td></tr>
			<tr><td><b>ID Pemda</td><td colspan = "4">:</b>{{ $kibbitems->idpemda }}</td></tr>	
			<tr><td><b>Kode Barang</td><td colspan = "4">:</b>{{ $kibbitems->kd_barang }}</td></tr>																								
			<tr><td><b>Thn Perolehan</td><td colspan = "4">:</b>{{ $kibbitems->thnperolehan }}</td></tr>							
			<tr><td><b>Tgl Perolehan</td><td colspan = "4">:</b>{{ date('d-m-Y', strtotime($kibbitems->tgl_perolehan))}}</td></tr>							
			<tr><td><b>Nama Barang</td><td colspan = "4">:</b>{{ $kibbitems->Nm_Aset5 }}</td></tr>																		
			<tr><td><b>Nomor Polisi</td><td colspan = "4">:</b>{{ $kibbitems->nomor_polisi }}</td></tr>																																																																					
			<tr><td><b>Tahun Cetak</td><td colspan = "4">:</b>{{ date('Y') }}</td></tr>																		
			<tr><td><b>Tahun Cetak</td><td colspan = "4">:</b>{{ date('Y') }}</td></tr>																		
		</tbody>
		<tbody>
			<tr><td colspan = "4" style="width: 100%;border: 1px solid #000000;"><b>INFORMASI TAMBAHAN</b></td></tr>
			<tr><td><b>Pemegang Barang</td><td colspan = "4">:</b>{{ $kibbitems->nama }}</td></tr>																		
			<tr><td><b>Kondisi Induk</td><td colspan = "4">:</b>{{ $kibbitems->kondisi }}</td></tr>																		
			<tr><td><b>Kondisi Akhir</td><td colspan = "4">:</b>{{ $kibbitems->kondisi_akhir }}</td></tr>																		
			<tr><td><b>Tahun Cetak</td><td colspan = "4">:</b>{{ date('Y') }}</td></tr>																		
		</tbody>
									
	@endforeach
	</tbody>
</table>

<!-- ************************************************************************** -->

</body>


</html>
