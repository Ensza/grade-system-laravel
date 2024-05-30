<button wire:loading.attr="disabled"
class="rounded border text-sm py-0.5 px-2 bg-blue-500 disabled:bg-blue-400 text-white" 
{{$attributes ?? ''}}>
    {{$slot}}
</button>