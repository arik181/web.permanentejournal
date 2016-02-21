@if( isset($add_button_url))
<div class="row show-grid-md">
    <div class="col-xs-12">
        <a href="{{ $add_button_url or '' }}" class="btn btn-primary btn-md pull-right">{{ $add_button_text or '' }}</a>
    </div>
</div>
@endif

<table id="tableList" class="table table-striped">
  <thead>
    <tr>
    @foreach ($table_headers as $header)
      <th>
      {{{ $header }}}
      </th>
    @endforeach
  </thead>
  </tr>
  @foreach ($table_items as $item)
  <tr>
    @foreach ($table_content as $content)
    <td class="admin-cell">
        {{ $item[$content] }}
    </td>
    @endforeach
  </tr>
  @endforeach
</table>

<script>
$(document).ready( function () {
    $('#tableList').DataTable( {{ $datatables_init }} );
});
</script>
