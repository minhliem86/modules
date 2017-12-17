@if(count($list_role))
{{Form::select('role_id',['' => 'Select role to assign'] + $list_role , old('role_id'), ['class'=> 'form-control', 'id' => 'role_id'] )}}
@else
  <select name="role_id" id="role_id" class="form-control selectpicker" disabled>
    <option value="" >Select Role</option>
  </select>
@endif
