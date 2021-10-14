<?php 

interface Form {

    public function openForm($method = 'post', $action);
    public function dataForm($type, $id, $name, $placeholder, $value, $disabled);
    public function closeForm($type, $value,$color);
}

class FormData implements Form {

    public function openForm($method = 'post', $action) {
        echo '<div class="container"><form action="'.$action.'" method="'.$method.'">';
    }

    public function dataForm($type, $id, $name, $placeholder, $value, $disabled) {
        echo '<div class=" row col-8"><label  for="'.$id.'">'.$id.'</label> <input type="'.$type.'" id="'.$id.'" name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" class="m-2 p-1 " required '.$disabled.'></div>';
    }
    
    public function closeForm($type, $value, $color){
        echo '<input type="'.$type.'" value="'.$value.'" class="btn '.$color.' m-3"></form></div>';
    }
}