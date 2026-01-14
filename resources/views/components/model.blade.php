
@props(['status','name','message','icon'=>'','title'=>''])

<button type="button" class="btn text-{{$status}}" data-toggle="modal" data-target="#{{$name}}">
        <i class='{{$icon}}'></i>
        {{$title}}
</button>
<div class="modal fade" id="{{$name}}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                {!! $message !!}
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {{$slot}}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
