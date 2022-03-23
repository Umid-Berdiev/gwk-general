    <button onclick="exportExcel()" type="button" class="btn btn-sm btn-success">
      {{ __('messages.Export') }}
    </button>
    {{-- <button >Export table to excel xlsx</button> --}}

@push('scripts')
<script src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>
  function exportExcel() {

    var workbook = XLSX.utils.book_new();

    var ws1 = XLSX.utils.table_to_sheet(document.getElementById('exportable_table'));
    XLSX.utils.book_append_sheet(workbook, ws1, "Таблица-1");

    /* convert table 'table2' to worksheet named "Sheet2" */
    var ws2 = XLSX.utils.table_to_sheet(document.getElementById('exportable_table_2'));
    XLSX.utils.book_append_sheet(workbook, ws2, "Таблица-2");

    /* convert table 'table2' to worksheet named "Sheet2" */
    var ws3 = XLSX.utils.table_to_sheet(document.getElementById('exportable_table_3'));
    XLSX.utils.book_append_sheet(workbook, ws3, "Таблица-3");

    /* convert table 'table2' to worksheet named "Sheet2" */
    var ws4 = XLSX.utils.table_to_sheet(document.getElementById('exportable_table_4'));
    XLSX.utils.book_append_sheet(workbook, ws4, "Таблица-4");

    /* convert table 'table2' to worksheet named "Sheet2" */
    var ws5 = XLSX.utils.table_to_sheet(document.getElementById('exportable_table_5'));
    XLSX.utils.book_append_sheet(workbook, ws5, "Таблица-5");

    /* convert table 'table2' to worksheet named "Sheet2" */
    var ws6 = XLSX.utils.table_to_sheet(document.getElementById('exportable_table_6'));
    XLSX.utils.book_append_sheet(workbook, ws6, "Таблица-6");

    /* convert table 'table2' to worksheet named "Sheet2" */
    var ws7 = XLSX.utils.table_to_sheet(document.getElementById('exportable_table_7'));
    XLSX.utils.book_append_sheet(workbook, ws7, "Таблица-7");

    /* convert table 'table2' to worksheet named "Sheet2" */
    var ws8 = XLSX.utils.table_to_sheet(document.getElementById('exportable_table_8'));
    XLSX.utils.book_append_sheet(workbook, ws8, "Таблица-8");

    /* convert table 'table2' to worksheet named "Sheet2" */
    var ws9 = XLSX.utils.table_to_sheet(document.getElementById('exportable_table_9'));
    XLSX.utils.book_append_sheet(workbook, ws9, "Таблица-9");

    /* convert table 'table2' to worksheet named "Sheet2" */
    var ws10 = XLSX.utils.table_to_sheet(document.getElementById('exportable_table_10'));
    XLSX.utils.book_append_sheet(workbook, ws10, "Таблица-10");


    return XLSX.writeFile(workbook, `Отчеты-{{date('d.m.Y H:i' ,strtotime(date('Y-m-d')))}}.xlsx`);

  }
</script>
@endpush
