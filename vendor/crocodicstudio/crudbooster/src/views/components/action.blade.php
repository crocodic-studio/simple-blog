@foreach($addaction as $a)
  <?php 
    foreach($row as $key=>$val) {
      $a['url'] = str_replace("[".$key."]",$val,$a['url']);
    }

    $label = $a['label'];
    $url = $a['url'];
    $icon = $a['icon'];
    $color = $a['color']?:'primary';

    if(isset($a['showIf'])) {

      $query = $a['showIf'];
      
      foreach($row as $key=>$val) {
        $query = str_replace("[".$key."]",'"'.$val.'"',$query);
      }              

      @eval("if($query) {
          echo \"<a class='btn btn-xs btn-\$color' title='\$label' href='\$url'><i class='\$icon'></i> $label</a>&nbsp;\";
      }");           

    }else{
      echo "<a class='btn btn-xs btn-$color' title='$label' href='$url'><i class='$icon'></i> $label</a>&nbsp;";              
    }
  ?>          
@endforeach

@if($button_action_style == 'button_text')               

      	@if(CRUDBooster::isRead() && $button_detail)         		
        	<a class='btn btn-xs btn-primary' title='{{trans("crudbooster.action_detail_data")}}' href='{{CRUDBooster::mainpath("detail/$row->id")."?return_url=".urlencode(Request::fullUrl())}}'>{{trans("crudbooster.action_detail_data")}}</a> 
        @endif
  		
  		@if(CRUDBooster::isUpdate() && $button_edit)     				    	
  			<a class='btn btn-xs btn-success' title='{{trans("crudbooster.action_edit_data")}}' href='{{CRUDBooster::mainpath("edit/$row->id")."?return_url=".urlencode(Request::fullUrl())."&parent_id=".g("parent_id")."&parent_field=".$parent_field }}'>{{trans("crudbooster.action_edit_data")}}</a> 
        @endif

        @if(CRUDBooster::isDelete() && $button_delete)
        	<?php $url = CRUDBooster::mainpath("delete/$row->id");?>
        	<a class='btn btn-xs btn-warning' title='{{trans("crudbooster.action_delete_data")}}' href='javascript:;' onclick='{{CRUDBooster::deleteConfirm($url)}}'>{{trans("crudbooster.action_delete_data")}}</a> 
        @endif
@elseif($button_action_style == 'button_icon_text')
       

      	@if(CRUDBooster::isRead() && $button_detail)         		
        	<a class='btn btn-xs btn-primary' title='{{trans("crudbooster.action_detail_data")}}' href='{{CRUDBooster::mainpath("detail/$row->id")."?return_url=".urlencode(Request::fullUrl())}}'><i class='fa fa-eye'></i> {{trans("crudbooster.action_detail_data")}}</a> 
        @endif
  		
  		@if(CRUDBooster::isUpdate() && $button_edit)     				    	
  			<a class='btn btn-xs btn-success' title='{{trans("crudbooster.action_edit_data")}}' href='{{CRUDBooster::mainpath("edit/$row->id")."?return_url=".urlencode(Request::fullUrl())."&parent_id=".g("parent_id")."&parent_field=".$parent_field }}'><i class='fa fa-pencil'></i> {{trans("crudbooster.action_edit_data")}}</a> 
        @endif

        @if(CRUDBooster::isDelete() && $button_delete)
        	<?php $url = CRUDBooster::mainpath("delete/$row->id");?>
        	<a class='btn btn-xs btn-warning' title='{{trans("crudbooster.action_delete_data")}}' href='javascript:;' onclick='{{CRUDBooster::deleteConfirm($url)}}'><i class='fa fa-trash'></i> {{trans("crudbooster.action_delete_data")}}</a> 
        @endif

@elseif($button_action_style == 'dropdown')

    <div class='btn-group btn-group-action'>
          <button type='button' class='btn btn-xs btn-primary btn-action'>{{trans("crudbooster.action_label")}}</button>
          <button type='button' class='btn btn-xs btn-primary dropdown-toggle' data-toggle='dropdown'>
            <span class='caret'></span>
            <span class='sr-only'>Toggle Dropdown</span>
          </button>
          <ul class='dropdown-menu dropdown-menu-action' role='menu'>
              @foreach($addaction as $a)
                <?php 
                  foreach($row as $key=>$val) {
                    $a['url'] = str_replace("[".$key."]",$val,$a['url']);
                  }

                  $label = $a['label'];
                  $url = $a['url']."?return_url=".urlencode(Request::fullUrl());
                  $icon = $a['icon'];
                  $color = $a['color']?:'primary';

                  if(isset($a['showIf'])) {

                    $query = $a['showIf'];
                    
                    foreach($row as $key=>$val) {
                      $query = str_replace("[".$key."]",'"'.$val.'"',$query);
                    }              

                    @eval("if($query) {
                        echo \"<li><a title='\$label' href='\$url'><i class='\$icon'></i> \$label</a></li>\";
                    }");           

                  }else{
                    echo "<li><a title='$label' href='$url'><i class='$icon'></i> $label</a></li>";              
                  }
                ?>          
              @endforeach

              @if(CRUDBooster::isRead() && $button_detail)            
                  <li><a title='{{trans("crudbooster.action_detail_data")}}' href='{{CRUDBooster::mainpath("detail/$row->id")."?return_url=".urlencode(Request::fullUrl())}}'><i class='fa fa-eye'></i> {{trans("crudbooster.action_detail_data")}}</a></li>
                @endif
              
              @if(CRUDBooster::isUpdate() && $button_edit)                    
                <li><a title='{{trans("crudbooster.action_edit_data")}}' href='{{CRUDBooster::mainpath("edit/$row->id")."?return_url=".urlencode(Request::fullUrl())."&parent_id=".g("parent_id")."&parent_field=".$parent_field}}'><i class='fa fa-pencil'></i> {{trans("crudbooster.action_edit_data")}}</a></li>
                @endif

                @if(CRUDBooster::isDelete() && $button_delete)
                  <?php $url = CRUDBooster::mainpath("delete/$row->id");?>
                  <li><a title='{{trans("crudbooster.action_delete_data")}}' href='javascript:;' onclick='{{CRUDBooster::deleteConfirm($url)}}'><i class='fa fa-trash'></i> {{trans("crudbooster.action_delete_data")}}</a></li>
                @endif
            </ul>
    </div>

@else

        @if(CRUDBooster::isRead() && $button_detail)            
          <a class='btn btn-xs btn-primary' title='{{trans("crudbooster.action_detail_data")}}' href='{{CRUDBooster::mainpath("detail/$row->id")."?return_url=".urlencode(Request::fullUrl())}}'><i class='fa fa-eye'></i></a> 
        @endif
      
      @if(CRUDBooster::isUpdate() && $button_edit)                    
        <a class='btn btn-xs btn-success' title='{{trans("crudbooster.action_edit_data")}}' href='{{CRUDBooster::mainpath("edit/$row->id")."?return_url=".urlencode(Request::fullUrl())."&parent_id=".g("parent_id")."&parent_field=".$parent_field}}'><i class='fa fa-pencil'></i></a> 
        @endif

        @if(CRUDBooster::isDelete() && $button_delete)
          <?php $url = CRUDBooster::mainpath("delete/$row->id");?>
          <a class='btn btn-xs btn-warning' title='{{trans("crudbooster.action_delete_data")}}' href='javascript:;' onclick='{{CRUDBooster::deleteConfirm($url)}}'><i class='fa fa-trash'></i></a> 
        @endif

@endif