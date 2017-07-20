<table class="table table-bordred">
	<thead class="thead-inverse">
		<tr class="gridSet">
			<th>#</th>
			<th>Penerima</th>
			@foreach($questions as $key => $question)
				@if($question->jumlah != null && $question->jenis_pertanyaan == 2)
					<th colspan="{{ $question->jumlah }}" style="text-align: center;" class="gridSet dont-break-out">{{ $question->pertanyaan }}</th>
				@else
					<th style="text-align: center;" class="gridSet dont-break-out">{{ $question->pertanyaan }}</th>
				@endif
			@endforeach
		</tr>
	</thead>
	<tbody>
		@foreach($recipients as $key => $recipient)
			<tr class="gridSet">
				<td>{{ $key+1 }}</td>
				<td>{{ $recipient->user->name }}</td>
				@foreach($responses as $key2 => $response)
				@if($recipient->user_id == $response->user_id)
					@if($response->detailQuestionare->jenis_pertanyaan == 2)
						
						@for($i = 1; $i <= $response->detailQuestionare->jumlah; $i++)
							<td>
							@if($response->{'image'.$i} != null)
								<img src="images/upload/{{ $response->{'image'.$i} }}" height="50px">
							@endif
							</td>
						@endfor
						
					@elseif($response->detailQuestionare->jenis_pertanyaan == 1)
						<td class="gridSet dont-break-out">{{ $response->response }}</td>
					@endif
				@endif
				@endforeach
			</tr>
		@endforeach
	</tbody>
</table>
<style>
	.gridSet {
		height: 38;
		width: 12;
		table-layout: fixed;
    	word-wrap: break-word;
	}
	.dont-break-out {
  		/* These are technically the same, but use both */
		overflow-wrap: break-word;
		word-wrap: break-word;

		-ms-word-break: break-all;
		/* This is the dangerous one in WebKit, as it breaks things wherever */
		word-break: break-all;
		/* Instead use this non-standard one: */
		word-break: break-word;

		/* Adds a hyphen where the word breaks, if supported (No Blink) */
		-ms-hyphens: auto;
		-moz-hyphens: auto;
		-webkit-hyphens: auto;
		hyphens: auto;
}
</style>