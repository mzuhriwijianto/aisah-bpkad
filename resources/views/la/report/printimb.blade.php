<!doctype html>
<html lang="en">
<head>
	
	<meta charset="UTF-8">
    <title>DATA GEDUNG & FOTO UDARA</title>
	
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Times New Roman"; font-size:x-small }
		a.comment-indicator:hover + comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em;  } 
		a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em;  } 
		comment { display:none;  }
		
	</style>
	<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script src='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet' />
<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.2.0/mapbox-gl-draw.js"></script>
<link
rel="stylesheet"
href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.2.0/mapbox-gl-draw.css"
type="text/css"
/>	


</head>


<body onload="vals()">

<table style="width: 100%;">
<tbody>
	<tr>
			<td style="width: 8%;text-align:center;">
				<b style = "font-size: 20px;" ><img src="{{ public_path('la-assets\img\Logo.jpg') }}" alt="Logo" width="45" class="logo"/></b>
				<!--<b style = "font-size: 20px;" ><img src="https://drive.google.com/thumbnail?id=1E9Gzlyi0RPb1-Vg6LDPM6i-O-UKGsuV8" alt="Logo" width="45" class="logo"/></b>-->
			</td>
			<br/>
			<td style="width: 50%;text-align:center;">
				<b style = "font-size: 20px;" > PEMERINTAH KABUPATEN BOJONEGORO</b>
				<br/>
				<b style = "font-size: 14px;">DATA IZIN MENDIRIKAN BANGUNAN PADA ASET PEMKAB </b>
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
<table style="width: 100%;">
	<tbody>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><b>DATA IMB GEDUNG DAN BANGUNAN</b></td>
		</tr>
	</tbody>
</table>
<table style="width: 100%;">
	<tbody>
		<tr>
			<td style="width: 19%;">PENCATAT KIBC</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;"> {{ $Dept }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">KOORD Y</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $koordy }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">KOORD X</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $koordx }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">NO. DOKUMEN</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $dokumen_nomor}}</td>
		</tr>
		<tr>
			<td style="width: 19%;">TGL PEROLEHAN</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $tgl_perolehan}}</td>
		</tr>

		<tr>
			<td style="width: 19%;">LOKASI</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $lokasi }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">PENGGUNAAN</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $keterangan }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">PEMANFAATAN</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $pemanfaatan }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">TANGGAL TERBIT IMB</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{($tgl_awal_imb)}}</td>
		</tr>
				<tr>
			<td style="width: 19%;">EXPIRED IMB</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $tgl_akhir_imb }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">ASAL - USUL</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{$asal_usul}}</td>
		</tr>
		<tr>
			<td style="width: 19%;">Harga</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">Rp. {{ number_format($harga, 2, ',', '.')  }}</td>
		</tr>
	</tbody>
</table>
<table style="width: 100%;">
	<tbody>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td><b>KELENGKAPAN DOKUMEN</b></td>
		</tr>
	</tbody>
</table>
<table>
	<tbody>
		<tr>
			<td>DOKUMEN IMB</td>
			<td>:</td>
			<td>{{ (( $upload_dok_imb == '' OR $upload_dok_imb== '0') ? 'Tidak Di Izinkan' : 'Izinkan') }}</td>
		</tr>
		<tr>
			<td>PHOTO</td>
			<td>:</td>
			<td>{{ (( $photo_gedung == '' OR $photo_gedung == '0') ? 'TIDAK ADA' : 'ADA') }}</td>
		</tr>
	</tbody>
</table>
<table style="width: 100%;">
	<tbody>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><b>FOTO UDARA</b></td>
		</tr>
		<tr align = "center">			
			<td>																								
				<div id ="mapid" style = " height: 450px;width: 450px;"></div>					
			</td>
			<td>
				
			</td>
			<td>
			</td>

		</tr>
		</tr>
	</tbody>
</table>

<p>&nbsp;</p>
<table style="width: 100%;">
	<tbody>
		<tr style="height: 5px;">
			<td>Print at</td>
			<td style="height: 8px; width: 1%;">:</td>
			<td style="height: 23px; width: 80%;">{{ date('d-m-Y') }} </td>
		</tr>
		<tr style="height: 5px;">
			<td>Print by</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ Module::userlogin()->dept_name }} - {{ Auth::user()->name }}</td>
		</tr>
		<tr style="height: 5px;">
			<td>Url</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ url(config('laraadmin.adminRoute')) }}</td>
		</tr>
	</tbody>
</table>
<!-- ************************************************************************** -->

</body>
<script language="JavaScript" type="text/javascript">
//convert to json
var locgedung = {
'type': 'geojson',
'data': {
		'type': 'Feature',
		'geometry': {
					'type': 'Polygon',
					'coordinates': [
								[
									{{ $koordx }}
								]
							]
					}
		}
};
//end

//init	

mapboxgl.accessToken = 'pk.eyJ1IjoiaWhzYW4zNyIsImEiOiJja3E5OHZwZmMwMDF3MnZueGl4c2twYTZvIn0.OdTBZzAAicPMfeOo-dBylQ';
var mymap = new mapboxgl.Map({
	container: 'mapid',
	center:locgedung.data.geometry.coordinates[0][locgedung.data.geometry.coordinates[0].length-1],
	//style: 'mapbox://styles/mapbox/satellite-v9',
	style: 'mapbox://styles/mapbox/satellite-streets-v10',
	preserveDrawingBuffer: true
});

		
//load save polygon
mymap.on('load', function() {
	mymap.addSource('gedungs', locgedung );
	mymap.addLayer({
			'id': 'gedungs',
			'type': 'fill',
			'source': 'gedungs',
			'layout': {},
			'paint': {
					'fill-color': '#e942f5',
					'fill-opacity': 0.6
					}
			});
});
//end
;

	
 var geom = mymap.fitBounds([
 locgedung.data.geometry.coordinates[0][0],
 locgedung.data.geometry.coordinates[0][locgedung.data.geometry.coordinates[0].length-1],
 ],{ zoom: 17 });
 

function vals(){
	var center = locgedung.data.geometry.coordinates[0][0]+','+locgedung.data.geometry.coordinates[0][locgedung.data.geometry.coordinates[0].length-1];
	var x1 = locgedung.data.geometry.coordinates[0][0];
	var x2 = locgedung.data.geometry.coordinates[0][3];
	//var center.x = x1 + ((x2 - x1) / 2);
	//var center.y = y1 + ((y2 - y1) / 2);
	//var srcgeom = 'geojson(%7B%22type%22%3A%22Point%22%2C%22coordinates%22%3A%5B-73.99%2C40.7%5D%7D)';
	//var sources = '<img alt="bojonegoro" src="https://api.mapbox.com/styles/v1/mapbox/satellite-v9/static/'+center+',11.38,0/350x270@2x?access_token=pk.eyJ1IjoicHJhdG9tb2dpbGFuZyIsImEiOiJjazhvNXFva20xMTgwM2ZtaW9nb2h1a2gzIn0.5Xu4wSzifGPaMy5F-taUkA">';
	var source = "https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v10/static/"+x2+",17.88,0/550x550?access_token=pk.eyJ1IjoicHJhdG9tb2dpbGFuZyIsImEiOiJjazhvNXFva20xMTgwM2ZtaW9nb2h1a2gzIn0.5Xu4wSzifGPaMy5F-taUkA";

	document.getElementById("sumber").src = source;
	//alert(x1);
	//locgedung.data.geometry.coordinates[0][locgedung.data.geometry.coordinates[0].length-1]);
	//document.write(x2);
	//return x2;
}
</script>

</html>
