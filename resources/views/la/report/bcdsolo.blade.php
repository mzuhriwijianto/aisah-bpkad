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

<div class="divTable unstyledTable">
    <table class="minimalistBlack" style="width: 50%;" align = "center">
		<thead>
		<tr id = "header">
				<td style="width: 3%;">No.</td>
				<td style="width: 8%;">No.Polisi</td>
				<td style="width: 15%;">No.BPKB</td>
				<td style="width: 10%;">Merk</td>
				<td style="width: 52%;">BARCODE</td>
		</tr>
		</thead>
			
		<tfoot>
		</tfoot>
		
		<tbody>
		@foreach ($kendaraans as $index =>$kendaraanarray)
		@php
			$barcode = $kendaraanarray->idpemda
		@endphp
		</br>
		
			<tr>
			<td style="text-align:center; height: 6%; font-size:10px;"> {{ $index + 1}}</td>
			<td style="text-align:center; height: 6%; font-size:10px;"> {{ $kendaraanarray->nomor_polisi }}</td>
			<td style="text-align:center; height: 6%; font-size:10px;"> {{ $kendaraanarray->nomor_bpkb }}</td>
			<td style="text-align:center; height: 6%; font-size:10px;"> {{ $kendaraanarray->merk }}</td>
			<td><div style = "padding: 10px;border: 0.5px solid #000;">
			{{'     '}} {!! 
						DNS1D::getBarcodeHTML($barcode, 'C128')
					!!} 
				{{'     '}}
				
			<div style="text-align:center;letter-spacing:2px;"> {{ $barcode }}</div>
				</div>
			</td>
			</tr>
		@endforeach
		</tbody>
		</tr>
	</table>
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