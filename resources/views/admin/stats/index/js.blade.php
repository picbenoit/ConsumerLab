<script type="text/javascript">
	$(function() {
	var colorList = [
		    "#008b8b", "#a9a9a9", "#006400", "#bdb76b", "#8b008b", "#556b2f", "#ff8c00", "#9932cc",
		    "#00ffff", "#f0ffff", "#f5f5dc", "#000000", "#0000ff", "#a52a2a", "#00ffff", "#00008b",
		    "#8b0000", "#e9967a", "#9400d3", "#ff00ff", "#ffd700", "#008000", "#4b0082", "#f0e68c",
		    "#add8e6", "#e0ffff", "#90ee90", "#d3d3d3", "#ffb6c1", "#ffffe0", "#00ff00", "#ff00ff",
		    "#800000", "#000080", "#808000", "#ffa500", "#ffc0cb", "#800080", "#800080", "#ff0000",
		    "#c0c0c0", "#ffffff", "#ffff00"
	];
	@foreach ($questionnaire->questions as $question)
		new Chart($('#chart-{{ $question->id }}'), {
			type: 'pie',
			data: {
				labels: [
					@foreach($question->choices->pluck('label') as $label)
					"{{ $label }}"@if (!$loop->last),@endif
					@endforeach
				],
				datasets: [{
					data: [
						{{ implode(',', $question->choices->map(function ($item, $key) {
							return count($item->answerChoices);
						})->all()) }}
					],
					backgroundColor: colorList
				}]
			}
		});
	@endforeach
	});
</script>
