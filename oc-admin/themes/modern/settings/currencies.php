<?php
    /**
     * OSClass – software for creating and publishing online classified advertising platforms
     *
     * Copyright (C) 2010 OSCLASS
     *
     * This program is free software: you can redistribute it and/or modify it under the terms
     * of the GNU Affero General Public License as published by the Free Software Foundation,
     * either version 3 of the License, or (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
     * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
     * See the GNU Affero General Public License for more details.
     *
     * You should have received a copy of the GNU Affero General Public
     * License along with this program. If not, see <http://www.gnu.org/licenses/>.
     */

    $aCurrencies = __get('aCurrencies') ;
    $last = end($aCurrencies); $last_id = $last['pk_c_code'] ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()) ; ?>">
    <head>
        <?php osc_current_admin_theme_path('head.php') ; ?>
        <link href="<?php echo osc_current_admin_theme_styles_url('demo_table.css') ; ?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo osc_current_admin_theme_js_url('jquery.dataTables.min.js') ; ?>"></script>
        <script type="text/javascript">
            $(function() {
                $.fn.dataTableExt.oApi.fnGetFilteredNodes = function ( oSettings ) {
                    var anRows = [];
                    for ( var i=0, iLen = oSettings.aiDisplay.length ; i < iLen ; i++ ) {
                        var nRow = oSettings.aoData[ oSettings.aiDisplay[i] ].nTr;
                        anRows.push( nRow );
                    }
                    return anRows;
                };

                $.extend( $.fn.dataTableExt.oStdClasses, {
                    "sWrapper": "dataTables_wrapper form-inline"
                } );

                oTable = $('#datatables_list').dataTable({
                    "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
                    "sPaginationType": "bootstrap",
                    "bInfo": false,
                    "bFilter": false,
                    "bPaginate": false,
                    "bProcessing": false,
                    "bLengthChange": false,
                    "aaData": [
                        <?php foreach($aCurrencies as $c) { ?>
                        [
                            '<input type="checkbox" name="code[]" value="<?php  echo osc_esc_html($c['pk_c_code']) ; ?>" />',
                            "<?php echo osc_esc_html($c['pk_c_code']) ; ?> " +
                                "<small>(<a onclick=\"javascript:return confirm('<?php echo addslashes( osc_esc_js( __("This action can't be undone. Are you sure you want to continue?") ) ) ; ?>');\" href=\"<?php echo osc_admin_base_url(true) ; ?>?page=settings&amp;action=currencies&amp;type=delete&amp;code=<?php echo urlencode($c['pk_c_code']); ?>\"><?php _e('Delete'); ?></a>" + 
                                " &middot; <a href=\"<?php echo osc_admin_base_url(true); ?>?page=settings&amp;action=currencies&amp;type=edit&amp;code=<?php echo urlencode($c['pk_c_code']); ?>\"><?php _e('Edit') ; ?></a>)</small>",
                            "<?php echo osc_esc_html($c['s_name']) ; ?>",
                            "<?php echo osc_esc_html($c['s_description']) ; ?>"
                        ]  <?php echo $last_id != $c['pk_c_code'] ? ',' : ''; ?>
                        <?php } ?>
                    ],
                    "aoColumns": [
                        {
                            "sTitle": '<input id="check_all" type="checkbox" />',
                            "sWidth": '10px',
                            "bSortable": false
                        },
                        {
                            "sTitle": "<?php echo osc_esc_html( __('Code') ) ; ?>"
                        },
                        {
                            "sTitle": "<?php echo osc_esc_html( __('Name') ) ; ?>"
                        },
                        {
                            "sTitle": "<?php echo osc_esc_html( __('Description') ) ; ?>"
                        }
                    ]
                });
            });
        </script>
        <script type="text/javascript" src="<?php echo osc_current_admin_theme_url('js/datatables.post_init.js') ; ?>"></script>
    </head>
    <body>
        <?php osc_current_admin_theme_path('header.php') ; ?>
        <!-- container -->
        <div id="content">
            <?php osc_current_admin_theme_path( 'include/backoffice_menu.php' ) ; ?>
            <!-- right container -->
		    <div class="right">
                <div class="header_title">
                    <h1 class="currencies"><?php _e('Currencies') ; ?></h1>
                </div>
                <?php osc_show_admin_flash_messages() ; ?>
                <!-- datatables currencies -->
                <form class="settings currencies datatables" id="datatablesForm" action="<?php echo osc_admin_base_url(true) ; ?>" method="post">
                    <input type="hidden" name="page" value="settings" />
                    <input type="hidden" name="action" value="currencies" />
                    <input type="hidden" name="type" value="delete" />
                    <div class="row">
                        <div class="span6">
                            <div id="example_length" class="dataTables_length">
                                <label>
                                    <select id="bulk_actions" class="display">
                                        <option value=""><?php _e('Bulk actions') ; ?></option>
                                        <option value="delete_all"><?php _e('Delete') ; ?></option>
                                    </select> <input type="button" id="bulk_apply" class="btn" value="<?php echo osc_esc_html( __('Apply') ) ; ?>">
                                </label>
                            </div>
                        </div>
                        <div class="span6 filter">
                            <div class="dataTables_filter" id="example_filter">
                                <a href="<?php echo osc_admin_base_url(true); ?>?page=settings&amp;action=currencies&amp;type=add" class="btn" id="button_open"><?php _e('Add') ; ?></a>
                            </div>
                        </div>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatables_list"></table>
                </form>
                <!-- /datatables currencies -->
            </div>
            <!-- /right container -->
        </div>
        <!-- /container -->
        <?php osc_current_admin_theme_path('footer.php') ; ?>
    </body>
</html>