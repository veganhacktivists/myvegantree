<?php
include_once "header.php";

$rt = true;
if(!$lg && !$vp){
	$rt = false;
}
if($lg && $lg != $id){
	$rt = false;
}
if($vp && $vp != $id){
	$rt = false;
}
?>

<link rel="stylesheet" href="css/fontawesome-iconpicker.min.css" >

<style>

.wrapper {
  border : 0px dotted #ccc; padding: 0px;
}


#sidebar {  }
#tree { background-color: white;

    background-size: cover;
    background-image: url(https://i.imgur.com/dEqI5GG.png);
	    height: 100vh;
		}

@media screen and (min-width: 600px) {
   .wrapper {
      height: auto; overflow: hidden; // clearing
   }
   #sidebar { padding: 20px;width: 400px; float: left;height: 100vh; }
   #tree { margin-left: 400px; }
}


.input-color {
    position: relative;
}

.input-color input {
    padding-left: 20px;
    margin-bottom: 10px;
}

.input-color .color-box {
    width: 30px;
    height: 30px;
    background-color: #ccc;
    left: 5px;
    top: 5px;

}


.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  width: 100%;
  padding: 8px 14px;
  text-align: left;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.top-container {
  background-color: #f1f1f1;
  padding: 30px;
  text-align: center;
}

.header {
  padding: 10px 16px;
  background: #f95318;
  color: #fff;
}

.content {
  padding: 16px;
}

.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}

.sticky + .content {
  padding-top: 102px;
}


input {
    margin: .4rem;
}

.label-name:disabled {
    background-color: #EEE !important;
}

</style>


<div class="wrapper">

<?php
	include_once "sidebar.php";
?>

<div id="tree">
<div class="header" id="myHeader">
  <h4><i class="fas fa-cog"></i>&nbsp;&nbsp;To edit your account details, go to Account <u><a href="https://myvegantree.org/account" style="color: #ffffff;">over here</a></u>!</h4>
</div>

<div class="pt-box" style="width: 574px;border-radius: 3px;margin: 20px 0px 0px 50px;background: #fff0;box-shadow: 0 0px 0px rgba(0, 0, 0, 0.13);">


	<div class="pt-form" id="send-detail" style="background-color: #ffffffba;">

	<h4><b>Customize your Vegan tree!</b></h4><br>

			 <p>You can customize the way your tree looks, along with creating labels that you can assign to individuals! Note: If you attempt to delete a custom label that is already assigned to existing people, those people will return to the default "Vegan" label.</p>
<br>

<h4><b>Label Customization</b></h4><br>
<table class="label-table">
<?php
		$sql = db_select(['table' => 'labels', 'where' => '(account_id IS NULL || account_id = ' . $_SESSION['login'] . ')']);
        $flag = true;
		while( $flag ) {
            $label = $sql->fetch_assoc();
            if( is_null( $label ) ) {
                $label = [ 'id' => '', 'name' => '', 'account_id' => -1, 'color' => '#00FF00', 'icon' => 'fas fa-leaf' ];
                $flag = false;
            }
            
            $disabled = is_null( $label[ 'account_id' ] ) ? 'disabled' : '';
            $alterHidden = $label[ 'account_id' ] == -1 ? ' style="display: none;"' : '';
            
?>
    <tr class="label-container<?php if($label[ 'account_id' ] == -1) echo ' new-label'; ?>">
        <td><input type="text" class="label-name" placeholder="New Label" value="<?=$label[ 'name' ]?>" data-value="<?=$label[ 'name' ]?>" <?=$disabled?>/></td>
        <td><input type="color" class="label-color" value="<?=$label[ 'color' ]?>" data-value="<?=$label[ 'color' ]?>" <?=$disabled?>/></td>
        <td>
            <div class="btn-group">
                <button data-selected="<?=$label[ 'icon' ]?>"  data-value="<?=$label[ 'icon' ]?>" type="button" class="icp icp-dd btn btn-default dropdown-toggle iconpicker-component label-icon" data-toggle="dropdown" <?=$disabled?>>
                    <i class="fa fa-fw"></i>
                    <span class="caret"></span>
                </button>
                <div class="dropdown-menu"></div>
            </div>
        </td>
        <td><?php if(!$disabled) {?>
            <button class="btn btn-success add-label" style="display: none;">Add</button>
            <div class="btn-group alter-label"<?=$alterHidden?>>
                <input type='hidden' class='label-id' value='<?=$label[ 'id' ]?>' />
                <button class="btn btn-success edit-label" style="display: none;">Save</button>
                <button class="btn btn-danger delete-label"><i class="fas fa-minus-square"></i></button>
            </div><?php }?>
        </td>
    </tr><?php } ?>
</table>

		<hr />
		<button type="submit" class="pt-button bg-0 update-labels"><i class="icons icon-login"></i>Update Customizations</button>

	</div>
</div>



</div>
</div>

<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery.livequery.js"></script>
<script src="js/custom.js"></script>
<script src="js/fontawesome-iconpicker.js"></script>
<script>
    
    var currentLabel = $( '.new-label' );
    var newLabel = currentLabel.clone(); // poor man's ngRepeat

    $( '.icp-dd' ).livequery( setupLabel );
    $( '.add-label' ).livequery( 'click', addLabel );
    $( '.edit-label' ).livequery( 'click', editLabel );
    $( '.delete-label' ).livequery( 'click', deleteLabel );
    $( '.label-name' ).livequery( 'input', updateLabelState );
    $( '.label-icon' ).livequery( 'iconpickerSelected', updateLabelState );
    $( '.label-color' ).livequery( 'change', updateLabelState );
    $( '.update-labels' ).click( updateAllLabels );

    function setupLabel() {
        
        $(this).iconpicker({});
        
    }
    
    function addLabel( e ) {
        
        var label = $( e.target ).parents( '.label-container' ), input = label.find( '.label-name' );
		
        var data = {
            name: input.val(),
            color: label.find( '.label-color' ).val(),
            icon: label.find( '.icp').data('iconpicker').iconpickerValue
        };
        
        $.post( 'ajax.php?pg=add-label', data, function( r ) {
		    
			if( !r.success ) {
				
				alert( 'Error: Unable to create new label: ' + r.error );
				return;
				
			}
		    
		    setValue( label, data );
			label.find( '.add-label' ).css( { display: 'none' } );
			label.find( '.alter-label' ).css( { display: 'inline-block' } );
			
			label = newLabel.clone();
			label.appendTo( '.label-table' );
			
			
		}, 'json' );
        
    }
    
    function editLabel( e ) {
        
        var editButton = $( e.target ), label = editButton.parents( '.label-container' );
        
        var data = {
            id: label.find( '.label-id' ).val(),
            name: label.find( '.label-name' ).val(),
            color: label.find( '.label-color' ).val(),
            icon: label.find( '.label-icon' ).data('iconpicker').iconpickerValue
        }
        
        $.post( 'ajax.php?pg=edit-label', data, function( r ) {
            
            if( !r.success ) {
				
				alert( 'Error: Unable to edit label: ' + r.error );
				return;
				
			}
        
            setValue( label, data );
            editButton.css( { display: 'none' } );
            
        }, 'json' );
        
    }
    
    function deleteLabel( e ) {
        
        var label = $( e.target ).parents( '.label-container' ), id = label.find( '.label-id' ).val(), name = label.find( '.label-name' ).val();
        $.get( 'ajax.php?pg=count-label', { id: id }, function( r ) {

            if(
                ( r.count == 0 && !confirm( 'Are you sure you want to delete label "' + name + '"?\nThis label is not assigned to anyone.' ) ) ||
                ( r.count != 0 && !confirm( 'Label "' + name + '" is attached to ' + ( r.count == 1 ? 'someone' : r.count + ' people'  ) + ', are you sure you want to delete it?' ) )
            )
                return;
            
            var data = {
                id: id
            }
            
            $.post( 'ajax.php?pg=delete-label', data, function( r ) { if( r.success ) label.remove() }, 'json' );

        }, 'json' );

        
    }
    
    function updateAllLabels() {
       
       $( '.label-container' ).each( function() {
            
            var label = $( this ), input = label.find( '.label-name' );
            
            if( input.prop( 'disabled' ) )
                return;
            
            var button = input.data( 'value' ) == '' ? label.find( '.add-label' ) : label.find( '.edit-label' );
            
            if( button.css( 'display' ) != 'none' ) // can be either of block or inline-block otherwise
                button.click();

       } );

    }
    
    function setValue( label, data ) {
       
       var input, props = [ 'name', 'color', 'icon' ];
       for( var i in props ) {
            input = label.find( '.label-' + props[ i ] );
            input.data( 'value', data[ props[ i ] ] );
       }
        
    }

    function updateLabelState( e ) {
        
        var label = $( e.target ).parents( '.label-container' ),
            name = label.find( '.label-name' ),
            color = label.find( '.label-color' ),
            icon = label.find( '.label-icon ' ),
            button = name.data( 'value' ) == '' ? 'add-label' : 'edit-label';

        var unchanged = name.val() == '' || ( name.data( 'value' ) == name.val() && color.data( 'value' ) == color.val() && icon.data( 'value' ) == icon.data('iconpicker').iconpickerValue );
        
        label.find( '.' + button ).css( { display: unchanged ? 'none' : 'inline-block' } );

    }
 
</script>
