@props(['id', 'title' => "", 'xdata' => "{}", 'header' => 'true', 'closable' => 'true', 'placement' => 'center', 'backdrop' => 'dynamic', 'backdropClasses' => 'bg-gray-900 bg-opacity-50  fixed inset-0 z-40'])

{{-- Akses xdata modal = modals.<nama modal>.xdata --}}

<div id="{{ $id }}" tabindex="-1" aria-hidden="false" x-data="modals.{{ $id }}.initData() " x-init="console.log(modalID);" class="fixed z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full text-white">
    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-gray-50 rounded-lg shadow">
            <!-- Modal header -->
            @if ($header == "true")
                <div class="flex items-start justify-between p-4 border-b border-gray-300 rounded-t">
                    <h3 x-text="title" class="text-xl font-semibold">
                    </h3>
                    <button @click="hide()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" >
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
            @endif
            {{ $slot }}
        </div>
    </div>
</div>
@once
    @push('before-scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
        <script>
            let modals = {};
        </script>
    @endpush
@endonce
@push('before-scripts')

    {{-- harus udah ada sebelum frontend.js --}}
    <script>
            
        // set the modal menu element
        var targetEl = document.getElementById('{{ $id }}');

        // options with default values
        var options = {
            placement: '{{ $placement }}',
            backdrop: '{{ $backdrop }}',
            backdropClasses: '{{ $backdropClasses }}',
            closable: {{ $closable }},
            onHide: () => {
                console.log('{{ $id }} is hidden');
            },
            onShow: () => {
                console.log('{{ $id }} is shown');
            },
            onToggle: () => {
                console.log('{{ $id }} has been toggled');
            }
        };

        modals = {
            ...modals,
            {{ $id }}: new Modal(targetEl, options)
        }
        
        Object.assign(modals.{{$id}},{...modals.{{$id}}.__proto__,
            initData:()=> {
                return { 
                    modalID: '{{ $id }}', 
                    title: "{{$title}}",
                    toggle(){ modals.{{$id}}.toggle();},
                    show(){ modals.{{$id}}.show();},
                    hide(){ modals.{{$id}}.hide();} ,
                    ...{!! $xdata !!},
                }
            },});
    </script>
@endpush
@push('after-javascript')
    <script>    

        Object.assign(modals.{{$id}},{...modals.{{$id}}.__proto__,xdata:modals.{{$id}}._targetEl._x_dataStack[0],a:"ye"});
    </script>
@endpush