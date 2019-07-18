<?php 
//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class for register post type.
 */
class TuqPostTypeQuiz {

/**
    * Holds the values to be used in the fields callbacks
    */
    private $options;
 
    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'init', array( $this, 'tuq_post_type' ) );
        add_action( 'add_meta_boxes', array( $this, 'tuq_quiz_register_metabox' ), 10, 5  );
        add_action( 'save_post', array( $this, 'tuq_save_metabox' ) );
    }    

/*
* The Ultimate Quiz Register Post Type
*/

 public function tuq_post_type() {

    $labels = array(
        'name'                  => _x( 'Ultimate Quiz', 'Ultimate Quiz', 'hire-expert-developer' ),
        'singular_name'         => _x( 'Ultimate Quiz', 'Ultimate Quiz', 'hire-expert-developer' ),
        'menu_name'             => __( 'Quiz', 'hire-expert-developer' ),
        'name_admin_bar'        => __( 'Ultimate Quiz', 'hire-expert-developer' ),
        'archives'              => __( 'Quiz Archives', 'hire-expert-developer' ),
        'parent_item_colon'     => __( 'Parent Quiz:', 'hire-expert-developer' ),
        'all_items'             => __( 'All Quiz', 'hire-expert-developer' ),
        'add_new_item'          => __( 'Add New Quiz', 'hire-expert-developer' ),
        'add_new'               => __( 'Add New', 'hire-expert-developer' ),
        'new_item'              => __( 'New Quiz', 'hire-expert-developer' ),
        'edit_item'             => __( 'Edit Quiz', 'hire-expert-developer' ),
        'update_item'           => __( 'Update Quiz', 'hire-expert-developer' ),
        'view_item'             => __( 'View Quiz', 'hire-expert-developer' ),
        'search_items'          => __( 'Search Quiz', 'hire-expert-developer' ),
        'not_found'             => __( 'Not found', 'hire-expert-developer' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'hire-expert-developer' ),
        'featured_image'        => __( 'Featured Image', 'hire-expert-developer' ),
        'set_featured_image'    => __( 'Set featured image', 'hire-expert-developer' ),
        'remove_featured_image' => __( 'Remove featured image', 'hire-expert-developer' ),
        'use_featured_image'    => __( 'Use as featured image', 'hire-expert-developer' ),
        'insert_into_item'      => __( 'Insert into item', 'hire-expert-developer' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'hire-expert-developer' ),
        'items_list'            => __( 'Quiz list', 'hire-expert-developer' ),
        'items_list_navigation' => __( 'Quiz list navigation', 'hire-expert-developer' ),
        'filter_items_list'     => __( 'Filter Quiz list', 'hire-expert-developer' ),
    );
    $args = array(
        'label'                 => __( 'Ultimate Quiz', 'hire-expert-developer' ),
        'description'           => __( 'Ultimate Quiz Description', 'hire-expert-developer' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'author','revisions',),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-post',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,        
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'the_ultimate_quiz', $args );

}

/*
* Quiz Register Metabox 
*/
 function tuq_quiz_register_metabox() {
    add_meta_box( 'tuq_quiz_meta_box', __( 'Quiz Box', 'hire-expert-developer' ), array( $this, 'tuq_quiz_metabox_callback' ), 'the_ultimate_quiz','normal', 'high' );
}

/*
* Quiz Metabox Callback
*/ 
 function tuq_quiz_metabox_callback($post) {
    $post_id = $post->ID; 
  
        $number_of_questions = get_post_meta( $post_id, '_tuq_number_of_questions', true );
        if(empty($number_of_questions)) {
              $number_of_questions = 0;
        }
        $numofq = 20;
        $qi=1;

    ?>
        <input type="hidden" name="number_of_questions" value="<?php echo $number_of_questions; ?>" class="number_of_questions" />
        
        <?php for($qin=1;$qin<=$numofq;$qin++) { 

        $quiz_question = get_post_meta( $post_id, '_tuq_quiz_question'.$qin,  true );
      
        if(is_array($quiz_question)) {
            
        
        if(empty($quiz_question)) {
            $quiz_question = array(); 

            $quiz_question['question'] = '';
            $quiz_question['options'] = array('0'=>'');
            $quiz_question['answer'] = ''; 

        }

        ?>
        <div class="tuq_add_quiz_question_box tuq_add_quiz_question_box1">
            
            <div class="tuq_add_quiz_question tuq_question_no1">
                <span>Question <?php echo $qi; ?>:</span><input type="text" name="tuq_quiz_question<?php echo $qi; ?>" value="<?php echo $quiz_question['question']; ?>" class="tuq_quiz_question" placeholder="Enter Question Here." />
            </div>
            <div class="tuq_options_container">
                <?php 
                $options = $quiz_question['options']; 
                if($options) {
                foreach($options as $opkey => $opvalue) { 
                    $opkey++;
                    ?>
                <div class="tuq_new_options_box tuq_options_no1"> 
                    <span>Option <?php echo $opkey; ?>:</span>
                    <input type="text" name="tuq_quiz_option<?php echo $qi; ?>[]" value="<?php echo $opvalue; ?>" class="tuq_quiz_option" placeholder="Enter Option Here." />
                    <span class="remove_option">Remove Option</span>
                </div>

                <?php } 
                } ?>

                <div class="add_ans_options">
                    <a href="javascript:void(0);">Add New Options</a> 
                </div>
            </div>
            <div class="select_correct_answer">
                <label for="tuq_quiz_answer">Select Correct Answers:</label> <br /> 
                 <ul>
                <?php
                if($options) {
                foreach($options as $opkey => $opvalue) { 
                 ?>
                 <li>
                 <input type="checkbox" <?php tuq_checked($quiz_question['answer'],$opkey); ?> id="tuq_quiz_answer<?php echo $qi.$opkey; ?>" name="tuq_quiz_answer<?php echo $qi; ?>[]" value="<?php echo $opkey; ?>"><label for="tuq_quiz_answer<?php echo $qi.$opkey; ?>">Option<?php _e($opkey+1); ?></label>
                </li>
                <?php 
                $opkey++;
                } 
                } ?>
                </ul>
                
            </div>
            <span class="remove_question">Remove Question</span>
        </div>
        <?php $qi++;
        }   } ?>
        <div class="add_new_question_wr">
            <a href="javascript:void(0);">Add New Question</a>
        </div>
    <?php
    
} 

/**
 * Save meta box content.
 */
function tuq_save_metabox( $post_id ) {

    // if ( ! check_ajax_referer( 'wpsap_setting_nonce_action', 'wpsap_security' ) ) {
    //  return;
    // }
   
    if(isset($_POST['number_of_questions'])) {
        update_post_meta( $post_id, '_tuq_number_of_questions',  $_POST['number_of_questions'] );
    }

         $Qnum = 20; //get_post_meta( $post_id, '_tuq_number_of_questions', true );

     for($qi=1;$qi<=$Qnum;$qi++) {

        if ( isset( $_POST['tuq_quiz_question'.$qi] ) ) {
            $quiz_question = array();

            $quiz_question['question'] = $_POST['tuq_quiz_question'.$qi];
            $quiz_question['options'] = $_POST['tuq_quiz_option'.$qi];
            $quiz_question['answer'] = $_POST['tuq_quiz_answer'.$qi]; 

            update_post_meta( $post_id, '_tuq_quiz_question'.$qi,  $quiz_question ); 
        } else {
            delete_post_meta( $post_id, '_tuq_quiz_question'.$qi); 
        }

     }

  
}


} // Class End

$TuqPostTypeQuiz = new TuqPostTypeQuiz();


/*
* Check if an array as output for checkbox
*/ 
function tuq_checked($array, $current) {
    if(is_array($array) && in_array($current, $array)) {
        $current = $array = 1;
        checked($array, $current);
    } else {

    }
    
}
