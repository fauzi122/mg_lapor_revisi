
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Laravelia - Edit Data With Bootstrap Modal Window In Laravel') }}</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <a href="" id="editCompany" data-toggle="modal" data-target='#practice_modal' data-id="{{ $item->id }}">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="modal fade" id="practice_modal">
                        <div class="modal-dialog">
                           <form id="companydata">
                                <div class="modal-content">
                                <input type="hidden" id="color_id" name="color_id" value="">
                                <div class="modal-body">
                                    <input type="text" name="name" id="name" value="" class="form-control">
                                </div>
                                <input type="submit" value="Submit" id="submit" class="btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;">
                            </div>
                           </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script>

$(document).ready(function () {
$('body').on('click', '#editCompany', function (event) {
    event.preventDefault();
    var id = $(this).data('id');
    $.get('category/' + id + '/edit', function (data) {
         $('#userCrudModal').html("Edit category");
         $('#submit').val("Edit category");
         $('#practice_modal').modal('show');
         $('#color_id').val(data.data.id);
         $('#name').val(data.data.name);
     })
});
}); 
</script>
@endpush 