<!doctype html>
<html lang="en">
<head>
	
	<meta charset="UTF-8">
    <title>DATA TANAH & FOTO UDARA</title>
	
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
				<!--<b style = "font-size: 20px;" ><img src="{{ public_path('la-assets\img\Logo.jpg') }}" alt="Logo" width="45" class="logo"/></b>-->
				<b style = "font-size: 20px;" ><img src="https://drive.google.com/thumbnail?id=1E9Gzlyi0RPb1-Vg6LDPM6i-O-UKGsuV8" alt="Logo" width="45" class="logo"/></b>
			</td>
			<td style="width: 50%;text-align:center;">
				<b style = "font-size: 20px;" > PEMERINTAH KABUPATEN BOJONEGORO</b>
				<br/>
				<b style = "font-size: 14px;">DATA TANAH & FOTO UDARA</b>
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
			<td><b>DATA TANAH</b></td>
		</tr>
	</tbody>
</table>
<table style="width: 100%;">
	<tbody>
		<tr>
			<td style="width: 19%;">Pencatat Tanah</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;"> {{ $Dept }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">Luas/M2</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $luas_m2 }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">Hak Tanah</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $hak_tanah }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">Sertipikat An</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $sertifikat_an }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">No. Sertipikat</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ ($Sertifikat_Nomor == 'NULL' OR $Sertifikat_Nomor == '') ? '-' : $Sertifikat_Nomor }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">Tanggal Sertipikat</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ ($Sertifikat_tanggal== 'NULL' OR $Sertifikat_tanggal == '') ? '-' : date('d-m-Y', strtotime($Sertifikat_tanggal)) }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">Alamat</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $alamat }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">Tahun Perolehan</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ date('Y', strtotime($tgl_perolehan)) }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">Tanggal Perolehan</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ date('d-m-Y', strtotime($tgl_perolehan)) }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">Penggunaan</td>
			<td style="width: 1%;">:</td>
			<td style="width: 80%;">{{ $penggunaan }}</td>
		</tr>
		<tr>
			<td style="width: 19%;">Asal Usul</td>
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
			<td>SERTIPIKAT</td>
			<td>:</td>
			<td>{{ (( $idsert == '' OR $idsert == '0') ? 'X' : 'V') }}</td>
		</tr>
		<tr>
			<td>PHOTO</td>
			<td>:</td>
			<td>{{ (( $idphoto == '' OR $idphoto == '0') ? 'X' : 'V') }}</td>
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
var loctanah = {
'type': 'geojson',
'data': {
		'type': 'Feature',
		'geometry': {
					'type': 'Polygon',
					'coordinates': [
								[
									{{ $geo }}
								]
							]
					}
		}
};
//end

//init	

mapboxgl.accessToken = 'pk.eyJ1IjoicHJhdG9tb2dpbGFuZyIsImEiOiJjazhvNXFva20xMTgwM2ZtaW9nb2h1a2gzIn0.5Xu4wSzifGPaMy5F-taUkA';
var mymap = new mapboxgl.Map({
	container: 'mapid',
	center:loctanah.data.geometry.coordinates[0][loctanah.data.geometry.coordinates[0].length-1],
	//style: 'mapbox://styles/mapbox/satellite-v9',
	style: 'mapbox://styles/mapbox/satellite-streets-v10',
	preserveDrawingBuffer: true
});

		
//load save polygon
mymap.on('load', function() {
	mymap.addSource('tanahkab', loctanah );
	mymap.addLayer({
			'id': 'tanahkab',
			'type': 'fill',
			'source': 'tanahkab',
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
 loctanah.data.geometry.coordinates[0][0],
 loctanah.data.geometry.coordinates[0][loctanah.data.geometry.coordinates[0].length-1],
 ],{ zoom: 17 });
 

function vals(){
	var center = loctanah.data.geometry.coordinates[0][0]+','+loctanah.data.geometry.coordinates[0][loctanah.data.geometry.coordinates[0].length-1];
	var x1 = loctanah.data.geometry.coordinates[0][0];
	var x2 = loctanah.data.geometry.coordinates[0][3];
	//var center.x = x1 + ((x2 - x1) / 2);
	//var center.y = y1 + ((y2 - y1) / 2);
	//var srcgeom = 'geojson(%7B%22type%22%3A%22Point%22%2C%22coordinates%22%3A%5B-73.99%2C40.7%5D%7D)';
	//var sources = '<img alt="bojonegoro" src="https://api.mapbox.com/styles/v1/mapbox/satellite-v9/static/'+center+',11.38,0/350x270@2x?access_token=pk.eyJ1IjoicHJhdG9tb2dpbGFuZyIsImEiOiJjazhvNXFva20xMTgwM2ZtaW9nb2h1a2gzIn0.5Xu4wSzifGPaMy5F-taUkA">';
	var source = "https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v10/static/"+x2+",17.88,0/550x550?access_token=pk.eyJ1IjoicHJhdG9tb2dpbGFuZyIsImEiOiJjazhvNXFva20xMTgwM2ZtaW9nb2h1a2gzIn0.5Xu4wSzifGPaMy5F-taUkA";

	document.getElementById("sumber").src = source;
	//alert(x1);
	//loctanah.data.geometry.coordinates[0][loctanah.data.geometry.coordinates[0].length-1]);
	//document.write(x2);
	//return x2;
}
</script>

</html>
