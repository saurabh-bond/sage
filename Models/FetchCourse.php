<?php

class FetchCourse extends DBClass
{
        public $requestData;
        public $requestedPage = 1;
        public $start = 0;
        public $rowPerPage = 5;
        
        public function processBusinessRules()
        {
                
                $sql = 'SELECT * FROM course WHERE active = 1 ORDER BY id DESC ';
                
                /* Pagination Code starts */
                $per_page_html = '';
                
                if (!empty($this->requestData["page"])) {
                        $this->requestedPage = $this->requestData["page"];
                        $this->start = ($this->requestedPage - 1) * $this->rowPerPage;
                }
                $limit = " limit " . $this->start . "," . $this->rowPerPage;
                
                $totalCount = $this->getRowsCount($sql);
                
                if (!empty($totalCount)) {
                        $per_page_html .= "<div style='text-align:center;margin:20px 0px;'>";
                        $page_count = ceil($totalCount / $this->rowPerPage);
                        if ($page_count > 1) {
                                for ($i = 1; $i <= $page_count; $i++) {
                                        if ($i == $this->requestedPage) {
                                                $per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page current" />';
                                        } else {
                                                $per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page" />';
                                        }
                                }
                        }
                        $per_page_html .= "</div>";
                }
                
                $query = $sql . $limit;
                $result = $this->selectQuery($query);
                $msg = "";
                if ($result['status'] == 200) {
                        $result = $result['data'];
                } else {
                        $msg = "Some error occurred, please try reloading the page.";
                }
                $data = [
                        'gridData' => $result,
                        'paginationHtml' => $per_page_html
                ];
                
                return $this->sendResponse(200, null, $msg, $data);
        }
        
        public function sendResponse($status, $err = null, $msg = "", $data = [])
        {
                return ['status' => $status, 'error' => $err, 'message' => $msg, 'data' => $data];
        }
}

?>
