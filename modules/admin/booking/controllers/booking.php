<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of booking
 *
 * @author Lachu
 */
class booking extends Admin_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        if (!_can("Booking")) {
            redirect(site_url("dashboard"));
        }
        $this->load->library('pagination');
        $this->load->model('booking_model');
    }

    function index() {
        if ($this->input->get()) {
            $key = $this->input->get('key');
            $center_id = $this->input->get('center_id');
            $filters = array(
                'key' => isset($key) ? $key : '',
                'center_id' => isset($center_id) ? $center_id : ''
            );
        } else {
            $filters = array();
        }
        $this->data['centers'] = $this->booking_model->getCenters();
        $this->data['filters'] = $filters;
        $events = $this->booking_model->getBookingsEvents($filters, $this->current_centre_role->center_id);
        foreach ($events as $event) {
            $event->veg = $this->booking_model->get_veg_meals_count($event->id);
            $event->non_veg = $this->booking_model->get_non_veg_meals_count($event->id);
        }

        $this->data['eventdata'] = $events;

        // debug($this->data['eventdata']);
        $this->gr_template->build('booking', $this->data);
    }

    function view_booking($event_id = null) {
        if ($event_id == null) {
            redirect(site_url('booking'));
        }
        $this->data['event_id'] = $event_id;
        $this->data['data'] = $this->booking_model->getBookingdata($event_id);
        $this->gr_template->build('view_booking', $this->data);
    }

    function downloadbooking($event_id = null) {
        if ($event_id == null) {
            redirect(site_url('booking'));
        }
        if ($this->input->get() && $this->input->get('type') == 'excel') {
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $data = $this->booking_model->getBookingdata($event_id);
            $event = $data['event'];
            $objsheet = $this->excel->getActiveSheet();
            $objsheet->setCellValue('B1', 'Event Name : ' . $event->name);
            $objsheet->mergeCells("B1:E1");
            $objsheet->mergeCells("B2:E2");
            $objsheet->mergeCells("B3:E3");
            $objsheet->mergeCells("B4:E4");
            $objsheet->mergeCells("B5:E5");
            $objsheet->setCellValue('B2', 'Address : ' . $event->address);
            $objsheet->setCellValue('B3', 'Start Date : ' . date(FORMAT_DATE, strtotime($event->start_date)));
            $objsheet->setCellValue('B4', 'End date : ' . date(FORMAT_DATE, strtotime($event->end_date)));
            $objsheet->setCellValue('B5', 'Attendance Fee : ' . $event->currrency_symbol . $event->attendance_fee);
            $objsheet->setCellValue('B7', 'Name');
            $objsheet->getStyle('B7')->getFont()->setBold(true);
            $objsheet->getColumnDimension('B')->setWidth(25);
            $objsheet->setCellValue('C7', 'E-mail');
            $objsheet->getStyle('C7')->getFont()->setBold(true);
            $objsheet->getColumnDimension('C')->setWidth(50);
            $objsheet->setCellValue('D7', 'Total Attendees');
            $objsheet->getStyle('D7')->getFont()->setBold(true);
            $objsheet->getColumnDimension('D')->setWidth(25);
            $objsheet->setCellValue('E7', 'Gateway');
            $objsheet->getStyle('E7')->getFont()->setBold(true);
            $row = 8;
            $i = 1;
            foreach ($data['order'] as $orderlist) {
                $objsheet->setCellValue('A' . $row, $i);
                $objsheet->setCellValue('B' . $row, $orderlist->first_name . " " . $orderlist->last_name);
                $objsheet->setCellValue('C' . $row, $orderlist->email);
                $objsheet->setCellValue('D' . $row, $orderlist->attend . '');
                $objsheet->setCellValue('E' . $row, $orderlist->gateway_name);
                $row++;
                $i++;
            }
            $filename = 'Bookings.xlsx'; //save our workbook as this file name
            header('Content-Type: application/excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"');
//tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
//force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
        } else {
//            $data=$this->booking_model->getBookingdata($event_id);
//            $event=$data['event'];    
//            $booking=array("event"=>$event,"Bookings"=>$data);
//            $array = json_decode(json_encode($booking), true);
//            $csv = array(array("Name of Center", "Country", "State", "City", "Address 2", "Address 1", "Pin code", "Total Events", "Total Seats", "Total Bookings"));
//            $array = array_merge($csv, $array);
//            $this->convert_to_csv($array, 'report.csv', ',');
        }
    }

    private function convert_to_csv($input_array, $output_file_name, $delimiter) {
        /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
        $f = fopen('php://memory', 'w');
        /** loop through array  */
        foreach ($input_array as $line) {
            /** default php csv handler * */
            fputcsv($f, $line, $delimiter);
        }
        /** rewrind the "file" with the csv lines * */
        fseek($f, 0);
        /** modify header to be downloadable csv file * */
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
        /** Send file to browser for download */
        fpassthru($f);
    }

}

?>
