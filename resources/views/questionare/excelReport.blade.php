<table style="table-layout: fixed; width: 12; height: 38">
	<thead style="width: 12; height: 38">
		<tr>
			<th>#</th>
			<th>Penerima</th>
			@foreach($questions as $key => $question)
				@if($question->jumlah != null && $question->jenis_pertanyaan == 2)
					<th colspan="{{ $question->jumlah }}" style="text-align: center;">{{ $question->pertanyaan }}</th>
				@else
					<th style="text-align: center; wrap-text: true">{{ $question->pertanyaan }}</th>
				@endif
			@endforeach
		</tr>
	</thead>
	<tbody>
		@foreach($recipients as $key => $recipient)
			<tr style="width: 12; height: 38; wrap-text: true">
				<td>{{ $key+1 }}</td>
				<td>{{ $recipient->user->name }}</td>
				@foreach($responses as $key2 => $response)
				@if($recipient->user_id == $response->user_id)
					@if($response->detailQuestionare->jenis_pertanyaan == 2)
						
						@for($i = 1; $i <= $response->detailQuestionare->jumlah; $i++)
							<td>
							@if($response->{'image'.$i} != null)
								<img src="images/upload/{{ $response->{'image'.$i} }}" height="38px">
							@endif
							</td>
						@endfor
						
					@elseif($response->detailQuestionare->jenis_pertanyaan == 1)
						<td style="wrap-text: true">{{ $response->response }}</td>
					@endif
				@endif
				@endforeach
			</tr>
		@endforeach
	</tbody>
</table>