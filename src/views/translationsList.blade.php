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
    	<div class="uk-container">
    		
			<div class="uk-card uk-card-default uk-margin-top">
				<div class="uk-card-header">
					Traduzioni
				</div>
				<div class="uk-card-body">
					
					<table id="table" class="display" style="width:100%">
						<thead>
							<tr>
								<th>File</th>
								<th>Chiave</th>
								<th>Valore</th>
								<th>Salva</th>
								<th>Elimina</th>
							</tr>
						</thead>
						<tbody>
							@foreach($translations as $fileName => $translations)
								@foreach($translations as $key)
									<tr>
										<td>{{ $fileName }}.php</td>
										<td>{{ $key }}</td>
										<td>
											<input id="{{ $fileName }}_{{ $key }}" type="text" name="{{ $fileName }}[{{ $key }}]" value="" />
										</td>
										<td>
											<a data-file="{{ $fileName }}" data-key="{{ $key }}" data-id="{{ $fileName }}_{{ $key }}" class="save" href="javascript:void(0)" uk-icon="refresh"></a>
										</td>
										<td>
											<a href="{{ route('ilBronza.translations.removeKey', [
												'file' => $fileName,
												'key' => $key
												]) }}" uk-icon="trash"></a>
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

				</div>
			</div>
    	</div>

    	<script type="text/javascript">
			$(document).ready(function() {

				$('body').on('click', '.save', function(e)
				{
					let value = $('#' + $(this).data('id')).val();
					let file = $(this).data('file');
					let key = $(this).data('key');

					const form = document.createElement('form');
					form.method = 'POST';
					form.action = "/{{ config('translationsmanager.routePrefix') }}/store-key/" + file + "/" + key;

					const hiddenField = document.createElement('input');
					hiddenField.type = 'hidden';
					hiddenField.name = 'string';
					hiddenField.value = value;

					form.appendChild(hiddenField);

					document.body.appendChild(form);
					form.submit();
				});

			    $('#table').DataTable({
			    	'pageLength' : 300,
			    	'stateSave' : true
			    });
			});
    	</script>
    </body>
</html>