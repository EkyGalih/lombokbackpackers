<x-filament::page>
    {{ $this->table }}

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('livewire:load', () => {
            const buildTreeData = (tbody) => {
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const tree = [];

                const map = {};
                rows.forEach(row => {
                    map[row.dataset.id] = { id: row.dataset.id, children: [] };
                });

                rows.forEach(row => {
                    const parentId = row.dataset.parentId;
                    if (parentId && map[parentId]) {
                        map[parentId].children.push(map[row.dataset.id]);
                    } else {
                        tree.push(map[row.dataset.id]);
                    }
                });

                return tree;
            };

            const tbody = document.querySelector('[wire\\:id="{{ $this->id }}"] table tbody');

            Sortable.create(tbody, {
                group: 'nested',
                animation: 150,
                handle: '.fi-sortable-handle',
                onEnd: () => {
                    const tree = buildTreeData(tbody);
                    Livewire.dispatch('saveTree', { tree: tree });
                }
            });
        });
    </script>

    <style>
        tr.depth-1 td {
            padding-left: 1rem;
        }
        tr.depth-2 td {
            padding-left: 2rem;
        }
        tr.depth-3 td {
            padding-left: 3rem;
        }
        tr.depth-4 td {
            padding-left: 4rem;
        }
    </style>
</x-filament::page>
