<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KARTU INVENTARIS BARANG</title>

    <style type="text/css">
        @page {
            margin: 0px;
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
            margin: 15px;
        }
        .information table {
            padding: 10px;
        }
div.unstyledTable {
}
.divTable.unstyledTable .divTableCell, .divTable.unstyledTable .divTableHead {
}
/* DivTable.com */
.divTable{ display: table; }
.divTableRow { display: table-row; }
.divTableHeading { display: table-header-group;}
.divTableCell, .divTableHead { display: table-cell; padding: 5px 4px;}
.divTableCell2, .divTableHead { display: table-cell; margin: 1px;}
.divTableCell3, .divTableHead { display: table-cell; font-size: 6.5px; margin: 1px;}
.divTableHeading { display: table-header-group;}
.divTableFoot { display: table-footer-group;}
.divTableBody { display: table-row-group;}

table.minimalistBlack {
  border: 0.5px #000000;
  width: 60%;
  text-align: left;
  border-collapse: collapse;
}
table.minimalistBlack td, table.minimalistBlack th {
  border: 1px #000000;
  padding: 5px 4px;
}
table.minimalistBlack tbody td {
  font-size: 9px;
}
table.minimalistBlack thead {
  background: #FFFFFF;
  background: -moz-linear-gradient(top, #ffffff 0%, #ffffff 66%, #FFFFFF 100%);
  background: -webkit-linear-gradient(top, #ffffff 0%, #ffffff 66%, #FFFFFF 100%);
  background: linear-gradient(to bottom, #ffffff 0%, #ffffff 66%, #FFFFFF 100%);
  border-bottom: 3px solid #000000;
}
table.minimalistBlack thead th {
  font-size: 17px;
  font-weight: bold;
  color: #000000;
  text-align: left;
}
table.minimalistBlack tfoot td {
  font-size: 14px;
}
div.minimalistBlack {
  border: 0px solid #FFFFFF;
  background-color: #FFFFFF;
  width: 100%;
  text-align: left;
}
.divTable.minimalistBlack .divTableCell, .divTable.minimalistBlack .divTableHead {
  padding: 5px 4px;
}
.divTable.minimalistBlack .divTableBody .divTableCell {
  font-size: 9px;
}
.divTable.minimalistBlack .divTableRow:nth-child(even) {
  background: #FFFFFF;
}
.divTable.minimalistBlack .divTableCell:nth-child(even) {
  background: #FFFFFF;
}
.minimalistBlack .tableFootStyle {
  font-size: 14px;
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
  border: 0px solid #AAAAAA;
}
.divTable.unstyledTable .divTableBody .divTableCell {
  font-size: 11px;
}
    </style>

</head>
<body>


<div class="information">

<div class="divTable unstyledTable">
	<div class="divTableBody">
		<div class="divTableRow">
			<div class = "divTableCell" align="left" style="width: 15%;">
				<img src="{{ public_path('la-assets\img\Logo.jpg') }}" alt="Logo" width="45" class="logo"/>
			</div>
			<div class="divTableCell2" align="center" style="width: 10%;">
			<pre>
				<b style = "font-size: 11px;" > PEMERINTAH KABUPATEN BOJONEGORO</b>
				<b>SURAT KETERANGAN PEMEGANG KENDARAAN</b>
				<b>KENDARAAN BERMOTOR</h3></b>
			</pre>
			</div>
			<div class="divTableCell3" align="right" style = "width: 40%;">
					<pre style = "margin: 25px 380px 0px 0px;">
						<b>B P K A D<b>
						<b>KABUPATEN BOJONEGORO</b>
						<p> <small>Jl. P. Mastumapel No.01 Bojonegoro<br/>Jawa Timur, Indonesia</small></p>
					</pre>
				</div>

		</div>
	</div>
</div>
<div class="divTable unstyledTable">
<table class="minimalistBlack"  style="width: 100%;">
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

<div class="invoice">
<h3>Data Kendaraan</h3>
    <table class="minimalistBlack" style="width: 70%;">
		<thead>
		</thead>

		<tfoot>
		</tfoot>
		<tbody>
			<tr>
				<td style="width: 30%;">Pemegang Kendaraan</td><td style="width: 80%; text-align: left;">: {{ $owner }}</td></tr>
			<tr>
				<td style="width: 20%;">Nomor Polisi</td><td style="width: 80%; text-align: left;">: {{ $nomor_polisi }}</td></tr>
			<tr>
				<td style="width: 20%;">Nomor BPKB</td><td style="width: 80%; text-align: left;">: {{ $nomor_bpkb }}</td></tr>
			<tr>
				<td style="width: 20%;">Tanggal Pajak</td><td style="width: 80%; text-align: left;">: {{ date('d-m-Y', strtotime($tax_date)) }}</td></tr>
			<tr>
				<td style="width: 20%;">Merk</td><td style="width: 80%; text-align: left;">: {{ $merk }}</td></tr>
			<tr>
				<td style="width: 20%;">Type</td><td style="width: 80%; text-align: left;">: {{ $type }}</td></tr>
			<tr>
				<td style="width: 20%;">CC</td><td style="width: 80%; text-align: left;">: {{ $cc }}</td></tr>
			<tr>
				<td style="width: 20%;">Kondisi</td><td style="width: 80%; text-align: left;">: {{ $kondisi }}</td></tr>
			<tr>
				<td style="width: 20%;">No Rangka</td><td style="width: 80%; text-align: left;">: {{ $nomor_rangka }}</td></tr>
			<tr>
				<td style="width: 20%;">No Mesin</td><td style="width: 80%; text-align: left;">: {{ $nomor_mesin }}</td></tr>
		</tbody>
		</tr>
	</table>
</div>
<div class="invoice">
<h3>Kelengkapan Dokumen</h3>
	<table class="minimalistBlack" style="width: 20%;">
		<tbody>
			<tr>
			<td>BPKB</td><td> : </td><td>{{ (( $idbpkb == '' OR $idbpkb == '0') ? 'X' : 'V') }}</td> </tr>
			<tr>
			<td>STNK</td><td> : </td><td>{{ (( $idstnk == '' OR $idstnk == '0') ? 'X' : 'V') }}</td> </tr>
			<tr>
			<td>Foto</td><td> : </td><td>{{ (( $idphoto == '' OR $idphoto == '0') ? 'X' : 'V') }}</td> </tr>
		</tbody>
	</table>
</div>
<div class="information" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 100%; font-size: 8px;">
                Print at :{{ date('d-m-Y') }} {{ url(config('laraadmin.adminRoute')) }}
            </td>
			<td align="left" style="width: 100%; font-size: 8px;">
                Print by :{{ Module::userlogin()->dept_name }} - {{ Auth::user()->name }}
            </td>
            <td align="right" style="width: 50%;">
            </td>
        </tr>

    </table>
</div>



</body>
</html>