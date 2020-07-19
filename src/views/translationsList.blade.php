<!DOCTYPE html>
<html>
    <head>
        <title>Title</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script
			src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
			integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
			crossorigin="anonymous"></script>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/css/uikit.min.css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />

		<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit-icons.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    </head>
    <body>

		<table id="example" class="display" style="width:100%">
			<thead>
				<tr>
					<th>File</th>
					<th>Chiave</th>
					<th>Valore</th>
					<th>Salva</th>
				</tr>
			</thead>
			<tbody>
				@foreach($files as $fileName => $translations)
					@foreach($translations as $key => $value)
						<tr>
							<td>{{ $fileName }}.php</td>
							<td>{{ $key }}</td>
							<td>
								<input type="text" name="{{ $fileName }}[{{ $key }}]" value="" />
							</td>
							<td>
								<span uk-icon="save"></span>
							</td>
						</tr>
					@endforeach
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th>File</th>
					<th>Chiave</th>
					<th>Valore</th>
					<th>Salva</th>
				</tr>
			</tfoot>
		</table>


    	<script type="text/javascript">
			$(document).ready(function() {
			    $('#table').DataTable();
			});
    	</script>
    </body>
</html>