<input {{$type ?? 'type="text"'}} 
class="border rounded px-2 outline-slate-500 aria-[invalid]:border-red-500 {{$class ?? ''}}" 
@error('name') aria-invalid="true" @enderror
{{$attributes ?? ''}}>