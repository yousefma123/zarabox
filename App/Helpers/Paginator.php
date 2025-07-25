<?php 

    namespace App\Helpers;
    use App\Helpers\Statement;

    class Paginator { 

        protected $statement;

        public $count;
        public $current_page;
        public $number_of_pages;
        public $limit;
        public $start;

        // public function __construct()
        // {
        // }

        public function __construct($table_name, $limit = 10, $where = '')
        {
            $this->statement = (new Statement());

            $count          = $this->statement->select("COUNT(`id`) AS count", $table_name, "fetch", $where)['fetch']['count'];
            $current_page   = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
            $number_of_pages= intval($count / $limit);
            if($count % 10 !== 0) $number_of_pages ++;
            if($current_page <= 0 || $current_page > $number_of_pages) $current_page = 1;
            $start          = ($current_page * $limit) - $limit;

            // return [
            //     "count"         => $count,
            //     "current_page"  => $current_page,
            //     "number_of_pages"=> $number_of_pages,
            //     "limit"         => $limit,
            //     "start"         => $start,
            // ];

            $this->count = $count;
            $this->current_page = $current_page;
            $this->number_of_pages = $number_of_pages;
            $this->limit = $limit;
            $this->start = $start;
        }

        public function render(): string
        {
            if ($this->count <= $this->limit) {
                return '';
            }

            $html = '<nav aria-label="Page navigation">';
            $html .= '<ul class="pagination m-0 p-0">';

            $prevDisabled = $this->current_page <= 1 ? 'disabled' : '';
            $html .= '<li class="page-item ' . $prevDisabled . '">
                        <a class="page-link border-start-0 rounded-0" href="?page=' . max(1, $this->current_page - 1) . '">السابق</a>
                    </li>';

            for ($page = 1; $page <= $this->number_of_pages; $page++) {
                if ($page > 6) break;
                $active = $this->current_page == $page ? 'active' : '';
                $html .= '<li class="page-item ' . $active . '">
                            <a class="page-link" href="?page=' . $page . '">' . $page . '</a>
                        </li>';
            }

            if ($this->number_of_pages > 6) {
                $html .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';

                if ($this->current_page > 6) {
                    $html .= '<li class="page-item active">
                                <a class="page-link" href="?page=' . $this->current_page . '">' . $this->current_page . '</a>
                            </li>';
                }
            }

            $nextDisabled = $this->current_page >= $this->number_of_pages ? 'disabled' : '';
            $html .= '<li class="page-item ' . $nextDisabled . '">
                        <a class="page-link rounded-0" href="?page=' . min($this->number_of_pages, $this->current_page + 1) . '">التالي</a>
                    </li>';

            $html .= '</ul></nav>';
            return $html;
        }
    }