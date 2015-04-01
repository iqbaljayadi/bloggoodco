<?php

/*
 * Used by templates to create the layout (rows + columns) in author.php, tag.php etc...
 * the layout is then populated with modules
 */


class td_template_layout {
    var $td_column_number;
    var $td_current_column = 1;

    var $td_post_count = 0;


    var $td_block_layout; //block layout class

    function __construct() {
        $this->td_block_layout = new td_block_layout();
    }

    /**
     * Reads the sidebar and calculates the columns based on that setting
     * @param $tds_sidebar sidebar setting
     */
    function set_sidebar_setting($tds_sidebar) {
        switch($tds_sidebar) {
            case 'sidebar_left':
                // 2 cols
                $this->set_columns(2);
                break;

            case 'no_sidebar':
                // 3 cols
                $this->set_columns(3);
                break;

            default:
                //default is one sidebar (right in general)  2 + 1(sidebar)
                $this->set_columns(2);
                break;

        }
    }

    /**
     * Set the column width of the layout (1 2 3)
     * @param $columns
     */
    function set_columns($columns) {
        $this->td_column_number = $columns;
    }

    /**
     * calculates the next position
     */
    function layout_next() {
        $this->td_post_count++;

        if ($this->td_column_number == $this->td_current_column) {
            $this->td_current_column = 1;
        } else {
            $this->td_current_column++;
        }
    }


    /**
     * 1. Opens a new row if it's not already opened
     * 2. opens the column (span 4 or 6) @todo no full width !!!
     * @return string the html generated
     */
    function layout_open_element() {
        $buffy = '';
        switch ($this->td_column_number) {
            case 2:
                $buffy .= $this->td_block_layout->open_row();
                $buffy .= $this->td_block_layout->open6();
                break;

            case 3:
                $buffy .= $this->td_block_layout->open_row();
                $buffy .= $this->td_block_layout->open4();
                break;
        }

        return $buffy;
    }

    /**
     * Closes the element, used after element
     * @return string
     */
    function layout_close_element() {
        $buffy = '';
        switch ($this->td_column_number) {
            case 2:
                //close span
                $buffy .= $this->td_block_layout->close6();

                //close row
                if ($this->td_current_column == 2) {
                    $buffy .= $this->td_block_layout->close_row();
                }
                break;

            case 3:
                //close span
                $buffy .= $this->td_block_layout->close4();

                //close row
                if ($this->td_current_column == 3) {
                    $buffy .= $this->td_block_layout->close_row();
                }
                break;
        }

        return $buffy;
    }

    /**
     * Closes all the spans and rows, used after while
     * @return string
     */
    function close_all_tags() {
        $buffy = '';
        $buffy .= $this->td_block_layout->close_all_tags();
        return $buffy;
    }
}

?>