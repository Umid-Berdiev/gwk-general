@push('scripts')
<script src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>
  function exportExcel() {
    const elt = document.getElementById("exportable_table");
    const wb = XLSX.utils.table_to_book(elt, {
      sheet: "Sheet JS"
    });
    return XLSX.writeFile(wb, `{{getDataEchangeName($selected_element)}}-{{date('Y-m-d')}}.xlsx`);
  }
</script>
@endpush
