<div x-data="menuBuilder()" x-init="init()">

    <div id="menu-list" class="space-y-2">
        @foreach ($menus as $menu)
            <div class="menu-item p-2 bg-gray-500 rounded" data-id="{{ $menu->id }}">
                {{ $menu->title }}

                @if ($menu->children->count())
                    <div class="submenu ml-4 space-y-1">
                        @foreach ($menu->children as $child)
                            <div class="menu-item p-2 bg-gray-600 rounded" data-id="{{ $child->id }}">
                                {{ $child->title }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <button wire:click="save" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
        Save
    </button>

</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
    function menuBuilder() {
        return {
            currentOrder: [],

            init() {
                this.initSortable(document.getElementById('menu-list'));
            },

            initSortable(container) {
                if (!container) return;

                new Sortable(container, {
                    group: 'nested',
                    animation: 150,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    onEnd: () => {
                        this.currentOrder = this.buildOrder(document.getElementById('menu-list'));
                    }
                });

                container.querySelectorAll('.submenu').forEach(sub => this.initSortable(sub));
            },

            buildOrder(container, parentId = null) {
                const items = [];
                container.querySelectorAll(':scope > .menu-item').forEach((el, index) => {
                    const id = el.getAttribute('data-id');
                    items.push({
                        id,
                        parent_id: parentId,
                        sort_order: index + 1
                    });

                    const submenu = el.querySelector(':scope > .submenu');
                    if (submenu) {
                        items.push(...this.buildOrder(submenu, id));
                    }
                });
                return items;
            },

            save() {
                if (!this.currentOrder.length) {
                    this.currentOrder = this.buildOrder(document.getElementById('menu-list'));
                }
                Livewire.dispatch('updateOrder', this.currentOrder);
            }
        }
    }
</script>
