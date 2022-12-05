<!doctype html>
<html lang="en">
<head>
	
	<meta charset="UTF-8">
    <title>LAMPIRAN PENGHAPUSAN</title>
	
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
				<b style = "font-size: 14px;">LAMPIRAN PENGHAPUSAN</b>
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
	@foreach ($ajnphp as $ajnphps)
		<tr>
			<td><b>UPB</b></td><td style="text-align:center;"><b>:</b></td><td>{{ $ajnphps->deptname }}</td>
			<td><b>NOMOR AJUAN</b></td><td style="text-align:center;"><b >:</b></td><td>{{ $ajnphps->no_ajuan }}</td>				
			<td><b>TGL AJUAN</b></td><td style="text-align:center;"><b>:</b></td><td>{{ $ajnphps->tgl_ajuan }}</td>				
		</tr>
		<tr>
			<td><b>NOMOR SURAT</b></td><td style="text-align:center;">:</b></td><td>{{ $ajnphps->no_surat }}</td>
			<td><b>TGL SURAT</b></td><td style="text-align:center;">:</b></td><td>{{ $ajnphps->tgl_surat }}</td>
			<td><b>JENIS AJUAN</b></td><td style="text-align:center;">:</b></td><td>{{ $ajnphps->jenis_ajuan }}</td>
		</tr>				
	@endforeach
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
				@if(count($data_a) == 0 )
					<h3></h3>
				@else
				<div class="divTable unstyledTable">
					<table style="width: 100%;">
						<tbody>
							<tr>
								<td><b style = "font-size: 14px;">TANAH</b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="divTable unstyledTable">
						<table class="minimalistBlack" style="width: 100%;">
						<thead>
						<tr id = "header">
							<td style="text-align:center;" >No.</td>
							<td style="text-align:center;">Kode Brg</td>
							<td style="text-align:center;" >No Reg</td>					
							<td style="text-align:center;" >Nama Brg</td>																													
							<td style="text-align:center;" >Luas M2</td>															
							<td style="text-align:center;" colspan="3">Status Tanah</td>															
							<td style="text-align:left;" >Alamat</td>																					
							<td style="text-align:center;" >Thn Perolehan</td>							
							<td style="text-align:center;" >Penggunaan</td>																																																													
							<td style="text-align:right;" >Harga</td>																																																																																																																																																				
							<td style="text-align:center;" >Validation Image</td>																																																																																																																																																				
						</tr>
						<tr id = "header">
							<td style="text-align:center;">Hak</td>
							<td style="text-align:center;">Tgl</td>
							<td style="text-align:center;">No</td>
						</tr>
						</thead>
						<tbody>
							@foreach ($data_a as $index =>$data_as)
							<tr>
								<td style="text-align:center;">{{ $index + 1 }}</td>
								<td style="text-align:center;">{{ $data_as->kd_barang }}</td>
								<td style="text-align:center;">{{ $data_as->no_reg }}</td>
								<td style="text-align:left;">{{ $data_as->Nm_Aset5 }}</td>
								<td style="text-align:center;">{{ $data_as->Luas_M2 }}</td>
								<td style="text-align:center;">{{ $data_as->Hak_Tanah }}</td>
								<td style="text-align:center;">{{ $data_as->Sertifikat_Tanggal }}</td>
								<td style="text-align:center;">{{ $data_as->Sertifikat_Nomor }}</td>
								<td style="text-align:left;">{{ $data_as->Alamat }}</td>
								<td style="text-align:center;">{{ $data_as->tgl_pembelian }}</td>
								<td style="text-align:center;">{{ $data_as->Penggunaan }}</td>
								<td style="text-align:right;">{{ $data_as->harga }}</td>
								<td style="text-align:center;">					
								@if($data_as->validation_img != '')
									{{ $data_as->imgname }}								
								@else
								<i>no pic</i>
								@endif					
								</td>
							</tr>
							@endforeach	
						</tbody>
						<tfoot>
							<tr>
							@foreach ($data_a_sum as $data_a_sum)
								<td colspan="11" align = "center"><b>TOTAL</B></td>								
								<td style="text-align:right;"><b>{{ $data_a_sum->total }}</b></td>
							@endforeach	
							</tr>
						</tfoot>													
						</table>
				</div>
				@endif

				@if(count($data_b) == 0 )
					<h3><a href="#"></a></h3>
				@else
				<!-- END timeline item -->
				<!-- timeline item -->				
				<div class="divTable unstyledTable">
					<table  style="width: 100%;">
						<tbody>
							<tr>
								<td><b style = "font-size: 14px;">PERALATAN & MESIN</b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="divTable unstyledTable">
						<table class="minimalistBlack" style="width: 100%;border: 0.1px solid black">
						<thead>
						<tr id = "header">							
							<td style="text-align:center;">No.</th>
							<td style="text-align:center;">Kode Brg</th>
							<td style="text-align:center;">No Reg</th>					
							<td style="text-align:center;">Nama Brg</th>
							<td style="text-align:center;">Thn Perolehan</th>				
							<td style="text-align:center;">Merk/Type</th>																																																																								
							<td style="text-align:center;">Asal Usul</th>																																																																																																																																							
							<td style="text-align:center;">Harga</th>																																																													
							<th style="text-align:center;">Nilai Buku</th>																																																													
							<th style="text-align:center;">KET</th>																																																																																							
							<th style="text-align:center;">Validation Image</th>
						 </tr>
						</thead>
						<tbody>
							@foreach ($data_b as $index =>$data_bs)
							<tr>
								<td style="text-align:center;">{{ $index + 1 }}</td>
								<td style="text-align:center;">{{ $data_bs->kd_barang }}</td>
								<td style="text-align:center;">{{ $data_bs->no_reg }}</td>
								<td style="text-align:left;">{{ $data_bs->Nm_Aset5 }}</td>
								<td style="text-align:center;">{{ $data_bs->tgl_pembelian }}</td>
								<td style="text-align:center;">{{ $data_bs->merk }} - {{ $data_bs->type }}</td>
								<td style="text-align:center;">{{ $data_bs->kondisi }}</td>
								<td style="text-align:right;">{{ $data_bs->harga }}</td>					
								<td style="text-align:right;">{{ $data_bs->nilaibuku }}</td>
								<td style="text-align:left;">{{ $data_bs->keterangan }}</td>
								<td style="text-align:center;">					
									@if($data_bs->validation_img != '')																																		
									<img src="{{ public_path('storage/php_pb/Image/'.$data_bs->imgname) }}" alt="gambar" width = "190" height = "160"/>									
									@else
									<i>no pic</i>
									@endif					
								</td>
							</tr>
							@endforeach	
						</tbody>
						<tfoot>
							<tr>
							@foreach ($data_b_sum as $data_b_sum)
								<td colspan="6" align = "center"><b>TOTAL</B></td>								
								<td style="text-align:right;"><b>{{ $data_b_sum->total }}</b></td>
								<td style="text-align:right;"><b>{{ $data_b_sum->totalnilaibuku }}</b></td>
								<td><b></b></td>
								<td><b></b></td>
								<td><b></b></td>
							@endforeach	
							</tr>
						</tfoot>
													
						</table>
				</div>
				@endif
				<!-- END timeline item -->
				<!-- timeline item -->
				@if(count($data_c) == 0 )
					<h3></h3>
				@else
				<div class="divTable unstyledTable">
					<table style="width: 100%;">
						<tbody>
							<tr>
								<td><b style = "font-size: 14px;">GEDUNG & BANGUNAN</b></td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="divTable unstyledTable">
						<table class="minimalistBlack" style="width: 100%;">
						<thead>
						<tr id = "header">
							<td style="text-align:center;">No.</td>
							<td style="text-align:center;">Kode Brg</td>
							<td style="text-align:center;">No Reg</td>					
							<td style="text-align:center;">Nama Brg</td>
							<td style="text-align:center;">Thn Perolehan</td>				
							<td style="text-align:center;">Luas Lantai</td>																																																																																																																																																																																																							
							<td style="text-align:center;">Harga</td>																																																													
							<td style="text-align:center;">Nilai Buku</td>																																																													
							<td style="text-align:center;">Lokasi</td>																																																																																																																																																																																																																																																																																																																																							
							<td style="text-align:center;">Validation Image</td>																																																																																																																																																																																																																																																																																																																																							
						 </tr>
						</thead>
						<tbody>
							@foreach ($data_c as $index =>$data_cs)
							<tr>
								<td style="text-align:center;">{{ $index + 1 }}</td>
								<td style="text-align:center;">{{ $data_cs->kd_barang }}</td>
								<td style="text-align:center;">{{ $data_cs->no_reg }}</td>
								<td style="text-align:left;">{{ $data_cs->Nm_Aset5 }}</td>
								<td style="text-align:center;">{{ $data_cs->tgl_pembelian }}</td>
								<td style="text-align:center;">{{ $data_cs->Luas_Lantai }}</td>
								<td style="text-align:right;">{{ $data_cs->harga }}</td>
								<td style="text-align:right;">{{ $data_cs->nilaibuku }}</td>
								<td style="text-align:left;">{{ $data_cs->lokasi }}</td>				
								<td style="text-align:center;">					
									@if($data_cs->validation_img != '')
										<img src="{{ public_path('storage/php_pb/Image/'.$data_cs->imgname) }}" alt="gambar" style="width:150px;height:120px;"/>							
									@else
									<i>no pic</i>
									@endif					
								</td>	
							</tr>
							@endforeach	
						</tbody>
						<tfoot>
							<tr>
							@foreach ($data_c_sum as $data_c_sum)
								<td colspan="6" align = "center"><b>TOTAL</B></td>								
								<td style="text-align:right;"><b>{{ $data_c_sum->total }}</b></td>
								<td style="text-align:right;"><b>{{ $data_c_sum->totalnilaibuku }}</b></td>
								<td><b></b></td>
								<td><b></b></td>
							@endforeach	
							</tr>
						</tfoot>
													
						</table>
				</div>
				@endif
				
				@if(count($data_d) == 0 )
					<h3></h3>
				@else
				<div class="divTable unstyledTable">
					<table style="width: 100%;">
						<tbody>
							<tr>
								<td><b style = "font-size: 14px;">JALAN JARINGAN & IRIGASI</b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="divTable unstyledTable">
						<table class="minimalistBlack" style="width: 100%;">
						<thead>
						<tr id = "header">
							<td style="text-align:center;">No.</th>
							<td style="text-align:center;">Kode Brg</th>
							<td style="text-align:center;">No Reg</th>					
							<td style="text-align:center;">Nama Brg</th>
							<td style="text-align:center;">Thn Perolehan</th>				
							<td style="text-align:center;">Konstruksi</th>																																																																																																																																																																																																							
							<td style="text-align:center;">Harga</th>																																																													
							<td style="text-align:center;">Nilai Buku</th>																																																													
							<td style="text-align:center;">Lokasi</th>																																																																																																																																																																																																																																																																																																													
							<td style="text-align:center;">KET</th>																																																																																																																																																																																																																																																																																																																																							
							<td style="text-align:center;">Validation Image</th>																																																																																																																																																																																																																																																																																																																																							
						 </tr>
						</thead>
						<tbody>
							@foreach ($data_d as $index =>$data_ds)
							<tr>
								<td style="text-align:center;">{{ $index + 1 }}</td>
								<td style="text-align:center;">{{ $data_ds->kd_barang }}</td>
								<td style="text-align:center;">{{ $data_ds->no_reg }}</td>
								<td style="text-align:left;">{{ $data_ds->Nm_Aset5 }}</td>
								<td style="text-align:center;">{{ $data_ds->tgl_pembelian }}</td>
								<td style="text-align:center;">{{ $data_ds->konstruksi }}</td>
								<td style="text-align:right;">{{ $data_ds->harga }}</td>
								<td style="text-align:right;">{{ $data_ds->nilaibuku }}</td>
								<td style="text-align:left;">{{ $data_ds->lokasi }}</td>				
								<td style="text-align:left;">{{ $data_ds->keterangan }}</td>				
								<td style="text-align:center;">					
									@if($data_ds->validation_img != '')
										<img src="{{ public_path('storage/php_pb/Image/'.$data_ds->imgname) }}" alt="gambar" />								
									@else
									<i>no pic</i>
									@endif					
								</td>			
							</tr>
							@endforeach	
						</tbody>
						<tfoot>
							<tr>
							@foreach ($data_d_sum as $data_d_sum)
							<td colspan="6" align = "center"><b>TOTAL</B></td>
							<td style="text-align:right;"><b>{{ $data_d_sum->total }}</b></td>
							<td style="text-align:right;"><b>{{ $data_d_sum->totalnilaibuku }}</b></td>
							<td><b></b></td>
							<td><b></b></td>
							<td><b></b></td>
							@endforeach	
							</tr>
						</tfoot>
													
						</table>
				</div>
				@endif

				@if(count($data_e) == 0 )
					<h3><a href="#"></a></h3>
				@else
				<div class="divTable unstyledTable">
					<table style="width: 100%;">
						<tbody>
							<tr>
								<td><b style = "font-size: 14px;">ASET TETAP LAINNYA</b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="divTable unstyledTable">
						<table class="minimalistBlack" style="width: 100%;">
						<thead>
						<tr id = "header">
							<td style="text-align:center;">No.</th>
							<td style="text-align:center;">Kode Brg</th>
							<td style="text-align:center;">No Reg</th>					
							<td style="text-align:center;">Nama Brg</th>
							<td style="text-align:center;">Thn Perolehan</th>				
							<td style="text-align:center;">Judul</th>																																																																																																																																																																																																							
							<td style="text-align:right;">Harga</th>																																																																																																																																																																																																																																																																																																																																																																									
							<td style="text-align:center;">KET</th>																																																																																																																																																																																																																																																																																																																																							
							<td style="text-align:center;">Validation Image</th>																																																																																																																																																																																																																																																																																																																																							
						 </tr>
						</thead>
						<tbody>
							@foreach ($data_e as $index =>$data_es)
							<tr>
								<td style="text-align:center;">{{ $index + 1 }}</td>
								<td style="text-align:center;">{{ $data_es->kd_barang }}</td>
								<td style="text-align:center;">{{ $data_es->no_reg }}</td>
								<td style="text-align:left;">{{ $data_es->Nm_Aset5 }}</td>
								<td style="text-align:center;">{{ $data_es->tgl_pembelian }}</td>
								<td style="text-align:left;">{{ $data_es->judul }}</td>
								<td style="text-align:right;">{{ $data_es->harga }}</td>			
								<td style="text-align:left;">{{ $data_es->keterangan }}</td>				
								<td style="text-align:center;">				
										@if($data_es->validation_img != '')
											<img src="{{ public_path('storage/php_pb/Image/'.$data_es->imgname) }}" alt="gambar" style="width:150px;height:120px;"/>							
										@else
										<i>no pic</i>
										@endif					
								</td>		
							</tr>
							@endforeach	
						</tbody>
						<tfoot>
							<tr>
							@foreach ($data_e_sum as $data_e_sum)
							<td colspan="6" align = "center"><b>TOTAL</B></td>								
							<td style="text-align:right;"><b>{{ $data_e_sum->total }}</b></td>
							<td><b></b></td>
							<td><b></b></td>
							@endforeach	
							</tr>
						</tfoot>
													
						</table>
				</div>

				@endif
				@if(count($data_f) == 0 )
					<h3><a href="#"></a></h3>
				@else
				<div class="divTable unstyledTable">
					<table style="width: 100%;">
						<tbody>
							<tr>
								<td><b style = "font-size: 14px;">KONSTRUKSI DALAM PENGERJAAN</b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="divTable unstyledTable">
						<table class="minimalistBlack" style="width: 100%;">
						<thead>
						<tr id = "header">
							<td style="text-align:center;" rowspan="2">No.</th>
							<td style="text-align:center;" rowspan="2">Kode Brg</th>
							<td style="text-align:center;" rowspan="2">No Reg</th>					
							<td style="text-align:center;" rowspan="2">Nama Brg</th>
							<td style="text-align:center;" colspan="3">Konstruksi Bangunan</th>
							<td style="text-align:center;" rowspan="2">Tgl Perolehan</th>																																																																																																																																																																																																											
							<td style="text-align:center;" rowspan="2">Harga</th>																																																																																																																																																																																																																																																																																																																																																																									
							<td style="text-align:center;" rowspan="2">KET</th>																																																																																																																																																																																																																																																																																																																																								
							<td style="text-align:center;" rowspan="2">Validation Image</th>																																																																																																																																																																																																																																																																																																																																						
						 </tr>
						 <tr class="bg-aqua">
							<td>Luas</td>
							<td>Bertingkat/Tidak</td>
							<td>Beton/Tidak</td>
						</tr>
						</thead>
						<tbody>
							@foreach ($data_f as $index =>$data_fs)
							<tr>
								<td style="text-align:center;">{{ $index + 1 }}</td>
								<td style="text-align:center;">{{ $data_fs->kd_barang }}</td>
								<td style="text-align:center;">{{ $data_fs->no_reg }}</td>
								<td style="text-align:left;">{{ $data_fs->nm_aset5 }}</td>
								<td style="text-align:center;">{{ $data_fs->luas }}</td>
								<td style="text-align:center;">{{ $data_fs->bertingkat }}</td>
								<td style="text-align:center;">{{ $data_fs->beton }}</td>					
								<td style="text-align:center;">{{ $data_fs->Tgl_Perolehan }}</td>
								<td style="text-align:right;">{{ $data_fs->harga }}</td>			
								<td style="text-align:left;">{{ $data_fs->keterangan }}</td>				
											
								<td style="text-align:center;">					
									@if($data_fs->validation_img != '')									
										<img src="{{ public_path('storage/php_pb/Image/'.$data_fs->imgname) }}" alt="gambar" style="width:150px;height:120px;"/>						
									@else
									<i>no pic</i>
									@endif					
								</td>			
							</tr>
							@endforeach	
						</tbody>
						<tfoot>
							
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
								<b style = "font-size: 14px; text-align:center;">{{ $ajnphps->jbt_pimpinan }}</b>
								<br>
								<br>
								<br>
								<br>
								<br>
								<br>
								<br>
								<u><b style = "font-size: 14px; text-align:center;">{{ $ajnphps->nm_pimpinan }}</b></u>
								<br>
								<b style = "font-size: 14px; text-align:center;">{{ $ajnphps->nip_pimpinan }}</b>
							</td>
						</tr>
					</tbody>

				</table>
<p>&nbsp;</p>
<div id="footer">
<table style="width: 100%;">
<hr/>
	<tbody>
		<tr>
			<td style="width: 10%;text-align:left;font-size: 7px;">
				<b>{{ Module::userlogin()->dept_name }}</b>
				<br/>
				<b>KABUPATEN <br/> BOJONEGORO</b>
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
