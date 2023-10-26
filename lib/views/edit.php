<?php

    if ( ! defined( 'ABSPATH' ) ) exit;

    $errors = get_transient('wpcpt_form_error') ?? array();
    $form_data = get_transient('wpcpt_form_data') ?? array();
    $form_success = get_transient('wpcpt_form_success') ?? false;
    $form_fail = get_transient('wpcpt_form_fail') ?? false; 

    delete_transient('wpcpt_form_error');
    delete_transient('wpcpt_form_data');
    delete_transient('wpcpt_form_fail');
    delete_transient('wpcpt_form_success');

    $single = $data['data'][0];
    $old_supports = (isset($single->supports)) ? explode(', ', $single->supports) : array();
    $old_taxonomies = (isset($single->taxonomies)) ? explode(', ', $single->taxonomies) : array();

    $supports = (isset($form_data['supports'])) ? explode(', ', $form_data['supports']) : $old_supports;
    $taxonomies = (isset($form_data['taxonomies'])) ? explode(', ', $form_data['taxonomies']) : $old_taxonomies;

?>
<div class="wrap">
    <h1 class="wp-heading-inline">Edit Post Type</h1>
    
    <div class="postbox wpcpt-post-box">
        <div class="postbox-header">
            <h2 class="ui-sortable-handle">Post Type Settings</h2>
        </div>
        <div class="inside">
            <div class="main">
                <form name="edit_cpt" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" >
                    <div class="">
                        <table>
                            <tr>
                                <td colspan="2">
                                    <div class="alert wpcpt-alert-success <?php echo ($form_success) ? '' : 'wpcpt-hidden' ?>">
                                        <?php echo ($form_success) ? esc_attr($form_success) : '' ?>
                                    </div>
                                    <div class="alert wpcpt-alert-fail <?php echo ($form_fail) ? '' : 'wpcpt-hidden' ?>">
                                        <?php echo ($form_fail) ? esc_attr($form_fail) : '' ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="slug">Post Type Slug <span>*</span></label></td>
                                <td>
                                    <input 
                                        type="text" name="slug" id="slug" 
                                        class="<?php echo (isset($errors['wpcpt_slug_err'])) ? 'wpcpt-red-border' : '';?>" 
                                        value="<?php echo (isset($form_data['slug'])) ? esc_attr($form_data['slug']) : esc_attr($data['data'][0]->slug);?>" 
                                        placeholder="The post type name/slug. Used for various queries." />
                                    <?php echo (isset($errors['wpcpt_slug_err'])) ? '<small>' . esc_attr($errors['wpcpt_slug_err']) . '</small>' : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="plural">Plural Label <span>*</span></label></td>
                                <td>
                                    <input 
                                        type="text" name="plural" id="plural" 
                                        class="<?php echo (isset($errors['wpcpt_plural_err'])) ? 'wpcpt-red-border' : '';?>"
                                        value="<?php echo (isset($form_data['plural'])) ? esc_attr($form_data['plural']) : esc_attr($data['data'][0]->plural);?>" 
                                        placeholder="(e.g. Services) Used in admin menu." />
                                    <?php echo (isset($errors['wpcpt_plural_err'])) ? '<small>' . esc_attr($errors['wpcpt_plural_err']) . '</small>' : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="singular">Singular Label <span>*</span></label></td>
                                <td>
                                    <input 
                                    type="text" name="singular" id="singular" 
                                    class="<?php echo (isset($errors['wpcpt_singular_err'])) ? 'wpcpt-red-border' : '';?>" 
                                    value="<?php echo (isset($form_data['singular'])) ? esc_attr($form_data['singular']) : esc_attr($data['data'][0]->singular);?>" 
                                    placeholder="(e.g. Service) Used where needed as single label." />
                                    <?php echo (isset($errors['wpcpt_singular_err'])) ? '<small>' . esc_attr($errors['wpcpt_singular_err']) . '</small>' : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="menu_icon">Menu Icon</label></td>
                                <td>
                                    <input 
                                        name="menu_icon" id="menu_icon" type="text"
                                        value="<?php echo (isset($form_data['menu_icon'])) ? esc_attr($form_data['menu_icon']) : esc_attr($data['data'][0]->menu_icon);?>" 
                                        placeholder="Paste dashicon class here or choose from button below." />
                                        <input class="button dashicons-picker" type="button" value="Choose Icon" data-target="#menu_icon" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="menu_position">Menu Position</label></td>
                                    <td>
                                        <input 
                                        name="menu_position" id="menu_position" type="number" 
                                        min="5" max="100" 
                                        value="<?php echo (isset($form_data['menu_position'])) ? esc_attr($form_data['menu_position']) : esc_attr($data['data'][0]->menu_position);?>" 
                                        placeholder="Select from range of 5 to 100" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="supports">Supports</label>
                                    <p>Check the 'None' option to set 'supports' to false.</p>
                                </td>
                                <td>
                                    <fieldset>
                                        <input type="checkbox" id="title" value="title" name="supports[]" <?php echo (($supports) && in_array('title', $supports)) ? 'checked' : '';?> /> 
                                        <label for="title">Title</label>
                                        <br />
                                        <input type="checkbox" id="editor" value="editor" name="supports[]" <?php echo (($supports) && in_array('editor', $supports)) ? 'checked' : '';?> /> 
                                        <label for="editor">Editor</label>
                                        <br />
                                        <input type="checkbox" id="featured_image" value="thumbnail" name="supports[]" <?php echo (($supports) && in_array('thumbnail', $supports)) ? 'checked' : '';?> /> 
                                        <label for="featured_image">Featured Image</label>
                                        <br />
                                        <input type="checkbox" id="post_excerpt" value="excerpt" name="supports[]" <?php echo (($supports) && in_array('excerpt', $supports)) ? 'checked' : '';?> /> 
                                        <label for="post_excerpt">Excerpt</label>
                                        <br />
                                        <input type="checkbox" id="trackbacks" value="trackbacks" name="supports[]" <?php echo (($supports) && in_array('trackbacks', $supports)) ? 'checked' : '';?> /> 
                                        <label for="trackbacks">Trackbacks</label>
                                        <br />
                                        <input type="checkbox" id="custom_fields" value="custom-fields" name="supports[]" <?php echo (($supports) && in_array('custom-fields', $supports)) ? 'checked' : '';?> /> 
                                        <label for="custom_fields">Custom Fields</label>
                                        <br />
                                        <input type="checkbox" id="comments" value="comments" name="supports[]" <?php echo (($supports) && in_array('comments', $supports)) ? 'checked' : '';?> /> 
                                        <label for="comments">Comments</label>
                                        <br />
                                        <input type="checkbox" id="revisions" value="revisions" name="supports[]" <?php echo (($supports) && in_array('revisions', $supports)) ? 'checked' : '';?> /> 
                                        <label for="revisions">Revisions</label>
                                        <br />
                                        <input type="checkbox" id="author" value="author" name="supports[]" <?php echo (($supports) && in_array('author', $supports)) ? 'checked' : '';?> /> 
                                        <label for="author">Author</label>
                                        <br />
                                        <input type="checkbox" id="page_attributes" value="page_attributes" name="supports[]" <?php echo (($supports) && in_array('page_attributes', $supports)) ? 'checked' : '';?> /> 
                                        <label for="page_attributes">Page Attributes</label>
                                        <br />
                                        <input type="checkbox" id="post_formats" value="post_formats" name="supports[]" <?php echo (($supports) && in_array('post_formats', $supports)) ? 'checked' : '';?> /> 
                                        <label for="post_formats">Post Formats</label>
                                        <br />
                                        <input type="checkbox" id="none" value="none" name="supports[]" <?php echo (($supports) && in_array('none', $supports)) ? 'checked' : '';?> /> 
                                        <label for="none">None</label>
                                        <br />
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="taxonomies">Taxonomies</label>
                                    <p>Add supports for taxonomies.</p>
                                </td>
                                <td>
                                    <fieldset>
                                        <input type="checkbox" id="category" value="category" name="taxonomies[]" <?php echo (isset($taxonomies) && in_array('category', $taxonomies)) ? 'checked' : '';?> /> 
                                        <label for="category">Categories</label>
                                        <br />
                                        <input type="checkbox" id="post_tag" value="post_tag" name="taxonomies[]" <?php echo (isset($taxonomies) && in_array('post_tag', $taxonomies)) ? 'checked' : '';?> /> 
                                        <label for="post_tag">Tags</label>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" class="button-primary" value="Edit Post Type" /></td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" name="action" value="handle_cpt_edit">
                    <input type="hidden" name="id" value="<?php echo esc_attr($single->id); ?>">
                    <input type="hidden" name="old_slug" value="<?php echo esc_attr($single->slug); ?>">
                   <?php wp_nonce_field( 'handle_cpt_edit_action', 'handle_cpt_edit_nonce' ); ?>
                </form>
            </div>
        </div>
    </div>
</div>