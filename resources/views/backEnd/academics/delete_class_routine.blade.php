<div class="text-center">
    <h4>@lang('Are you sure to delete?')</h4>
</div>

<div class="mt-40 d-flex justify-content-between">
    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
    <a href="{{url('delete-class-routine/'.@$id)}}" class="text-light">
    <button class="primary-btn fix-gr-bg" type="submit">@lang('lang.delete')</button>
     </a>
</div>
