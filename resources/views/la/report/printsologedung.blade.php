<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KARTU INVENTARIS BARANG</title>

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

table.minimalistBlack {
  border: 0.3px solid #000000;
  width: 60%;
  text-align: left;
  border-collapse: collapse;
}
table.minimalistBlack td, table.minimalistBlack th {
  border: 0.3px 0.3px 0.3px 0.3px solid #000000;
  padding: 5px 4px;
}
table.minimalistBlack tbody td {
	border: 0.1px solid #000000;
  font-size: 9px;
}
table.minimalistBlack thead {
  background: #FFFFFF;
  border: 0.1px solid #000000;
}
table.minimalistBlack thead th {
  font-size: 9px;
  font-weight: bold;
  color: #000000;
  text-align: left;
  background-color: #ededed;
}
table.minimalistBlack tfoot td {
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
/* DivTable.com */
.divTable{ display: table; }
.divTableRow { display: table-row; }
.divTableHeading { display: table-header-group;}
.divTableCell, .divTableHead { display: table-cell;}
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
 #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: #ededed; text-align: center; }
    </style>

</head>
<body>


<div class="information">
	<div class="divTable unstyledTable">
		<div class="divTableBody">
			<div class="divTableRow">
				<div class = "divTableCell" align="left" style="width: 20%;">
					<img src="{{ public_path('la-assets\img\Logo.jpg') }}" alt="Logo" width="40px" class="logo"/>
				</div>
				<div class="divTableCell2" align="center">
				<pre>
					<b style = "font-size: 11px;" > PEMERINTAH KABUPATEN BOJONEGORO</b>
					<b>KARTU INVENTARIS BARANG</b>
					<b>BIDANG GEDUNG DAN BANGUNAN</h3></b>
				</pre>
				</div>			
				<div class="divTableCell3" align="left" style = "width: 40%;">
					<pre style = "margin: 10px 0px 0px 1px;">
						<b>BADAN PENGELOLAAN KEUANGAN DAN <b>
						</b>ASET DAERAH<b>
						<b>KABUPATEN BOJONEGORO</b>
						<p> <small>Jl. P. Mastumapel No.01 Bojonegoro<br/>Jawa Timur, Indonesia</small></p>
					</pre>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="divTable unstyledTable">
<table class="unstyledTable"  style="width: 100%;">
		<tbody>
			<tr>
				<td>PROVINSI</td><td>:</td><td>JAWA TIMUR</td></tr>
			<tr>
				<td>KAB/KOTA</td><td>:</td><td  style="width: 500%;">PEMERINTAH KABUPATEN BOJONEGORO</td></tr>
			<tr>
				<td>UPB</td><td>:</td><td>{{ Module::userlogin()->dept_name }}</td></tr>
		</tbody>
		<hr>
	</table>
</div>
<br/>
<div class="divTable unstyledTable">
    <table class="minimalistBlack" style="width: 100%;" align = "center">
		<thead>
		<tr id = "header">
				<td style="width: 3%;">No.</td>
				<td style="width: 10%;">Pencatat</td>
				<td style="width: 8%;">Koordinator X</td>
				<td style="width: 8%;">Koordinator Y</td>
				<td style="width: 3%;">No. Reg</td>
				<td style="width: 10%;">No.Dokumen</td>
				<td style="width: 10%;">Tgl Dokumen</td>
				<td style="width: 10%;">Alamat</td>
				<td style="width: 5%;">Tanggal Perolehan</td>
				<td style="width: 10%;">Harga</td>
				<td style="width: 10%;">IMB File</td>
				<td style="width: 5%;">Foto Gedung</td>

		</tr>
		</thead>
			
		<tfoot>
		</tfoot>
		<tbody>
		@foreach ($gbs as $index =>$gbarray)
			<tr>
			<td style="text-align:center;"> {{ $index + 1}}</td>
			<td style="text-align:left;"> {{ $gbarray->Dept }}</td>
			<td style="text-align:left;"> {{ $gbarray->koordx }}</td>
			<td style="text-align:left;"> {{ $gbarray->koordy }}</td>
      <td style="text-align:left;"> {{ $gbarray->no_register }}</td>
      <td style="text-align:left;"> {{ $gbarray->dokumen_nomor }}</td>
			<td style="text-align:left;"> {{ date('d-m-Y', strtotime($gbarray->dokumen_tanggal)) }}</td>
			<td style="text-align:left;"> {{ $gbarray->lokasi}}</td>
			<td style="text-align:left;"> {{ date('d-m-Y', strtotime($gbarray->tgl_perolehan)) }}</td>
      <td style="text-align:left;">Rp.  {{ number_format(($gbarray->harga)) }}</td>
			<td style="text-align:center;">{{ (( $gbarray->dokumen == '' OR $gbarray->dokumen == 0) ? 'NIHIL' : 'ADA') }}</td>
			<td style="text-align:center;">{{ (( $gbarray->photogedung == '' OR $gbarray->photogedung == 0) ? 'NIHIL' : 'OK') }}</td>
			

			</tr>
		@endforeach
		</tbody>
		</tr>
	</table>
</div>
</br>
		<div class="information" align="left" style="font-size:11px">
				<pre>
					<b style = "padding:5%" >MENGETAHUI</b>
					</br>
					<b>KEPALA {{ Module::userlogin()->dept_name }}</b>
					</br>
					</br>
					<p style="padding:5%;"><u>Ir. Gatot Subroto</u></p>
				</pre>
		</div>	
		
		<div class="information" align="right" style="font-size:11px" style="margin-bottom:50%;">
				<pre>
					<!--<b style = "padding:5%" >MENGETAHUI</b>-->
					</br>
					<b>PENGURUS BARANG {{ Module::userlogin()->dept_name }}</b>
					</br>
					</br>
					<p style="padding:5%;"><u>Ir. Gatot Subroto</u></p>
				</pre>
		</div>	

<div class="information" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 100%; font-size: 8px;">
                Print at :{{ date('d-m-Y') }} {{ url(config('laraadmin.adminRoute')) }}
            </td>
			<td align="left" style="width: 100%; font-size: 8px;">
                Print by : {{ Module::userlogin()->dept_name }} - Username : {{ Auth::user()->name }}
            </td>
            <td align="right" style="width: 50%;">
            </td>
        </tr>

    </table>
</div>



</body>
</html>