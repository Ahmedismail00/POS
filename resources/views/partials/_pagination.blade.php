<div class="box-footer clearfix">
    <ul class="pagination pagination-sm no-margin pull-right">
        {!! $records->appends($request->query())->links() !!}
    </ul>
</div>
