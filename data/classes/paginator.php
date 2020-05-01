<?php
class Paginator
{

    private $default_args, $args;
    private $db_con, $query, $limit_per_page, $page_number, $page_url, $wp, $pagination_classes, $pagination_links_limit;
    private $total_results, $limit_query;

    public function __construct($args = '')
    {
        $this->setDefaultArgs(array(
            "db_con" => '',
            "query" => '',
            "limit_per_page" => 10,
            "page_number" => 1,
            "page_url" => '',
            "wp" => false,
            "pagination_classes" => 'pagination justify-content-center pagination-separate pagination-flat',
            "pagination_links_limit" => 3
        ));
        $this->args = $args;
        $this->setCon($this->get_arg('db_con'));
        $this->setQuery($this->get_arg('query'));
        $this->setLimitPerPage($this->get_arg('limit_per_page'));
        $this->setPageNumber($this->get_arg('page_number'));
        $this->setPageUrl($this->get_arg('page_url'));
        $this->setWp($this->get_arg('wp'));
        $this->setPaginationClasses($this->get_arg('pagination_classes'));
        $this->setPaginationLinksLimit($this->get_arg('pagination_links_limit'));
        $this->setTotalResults('');
        $this->setLimitQuery('');
    }

    // setters
    //private
    private function setDefaultArgs($default_args)
    {
        $this->default_args = $default_args;
    }
    private function setTotalResults($total_results)
    {
        $this->total_results = $total_results;
    }
    private function setLimitQuery($limit_query)
    {
        $this->limit_query = $limit_query;
    }
    //public
    public function setCon($db_con)
    {
        $this->db_con = $db_con;
    }
    public function setQuery($query)
    {
        $this->query = $query;
    }
    public function setLimitPerPage($limit_per_page)
    {
        $this->limit_per_page = is_numeric($limit_per_page) ? $limit_per_page : -1;
    }
    public function setPageNumber($page_number)
    {
        $this->page_number = $page_number;
    }
    public function setPageUrl($page_url)
    {
        $this->page_url = $page_url;
    }
    public function setWp($wp)
    {
        $this->wp = $wp;
    }
    public function setPaginationClasses($pagination_classes)
    {
        $this->pagination_classes = $pagination_classes;
    }
    public function setPaginationLinksLimit($pagination_links_limit)
    {
        $this->pagination_links_limit = $pagination_links_limit;
    }
    // getters
    // private
    private function get_default_arg($arg)
    {
        return isset($this->default_args[$arg]) ? $this->default_args[$arg] : '';
    }
    private function get_arg($arg)
    {
        return isset($this->args[$arg]) ? $this->args[$arg] : $this->get_default_arg($arg);
    }
    //public
    public function getCon()
    {
        return $this->db_con;
    }
    public function getQuery()
    {
        return $this->query;
    }
    public function getLimitPerPage()
    {
        return $this->limit_per_page;
    }
    public function getPageNumber()
    {
        return $this->page_number;
    }
    public function getPageUrl()
    {
        return $this->page_url;
    }
    public function getWp()
    {
        return $this->wp;
    }
    public function getPaginationClasses()
    {
        return $this->pagination_classes;
    }
    public function getPaginationLinksLimit()
    {
        return $this->pagination_links_limit;
    }
    //private
    private function is_wp()
    {
        return !empty($GLOBALS["wpdb"]) && $this->getWp();
    }
    private function getTotalResults()
    {
        if ($this->total_results === '') $this->countTotalResults();
        return $this->total_results;
    }
    private function countTotalResults()
    {
        if ($this->is_wp())
        {
            $this->getCon()
                ->get_results($this->getQuery());
            $this->setTotalResults($this->getCon()
                ->num_rows);
        }
        else
        {
            $count = $this->getCon()
                ->query($this->getQuery());
            $this->setTotalResults(mysqli_num_rows($count));
        }
    }
    private function getPreviousLimit()
    {
        if ($this->getTotalPages() != 1)
        {
            $previous_limit = ($this->getPageNumber() - 1) * $this->getLimitPerPage();
        }
        else
        {
            $this->setLimitPerPage($this->getTotalResults());
            $previous_limit = - 1;
        }

        return $previous_limit;
    }
    private function calcLimitQuery()
    {
        $previous_limit = $this->getPreviousLimit();
        $query_string = ($previous_limit != - 1) ? ' LIMIT ' . $this->getLimitPerPage() . ' OFFSET ' . $previous_limit : '';
        if ($this->is_wp())
        {
            $result = $this->getQuery() . $query_string;
        }
        else
        {
            $result = $this->getCon()
                ->query($this->getQuery() . $query_string);
        }
        $this->setLimitQuery($result);
    }
    //functions to use outside class
    public function getLimitQuery()
    {
        if ($this->limit_query === '') $this->calcLimitQuery();
        return $this->limit_query;
    }
    public function getTotalPages()
    {
        $total_results = $this->getTotalResults();
        $limit_per_page = $this->getLimitPerPage();
        return ($limit_per_page !== - 1) ? ceil($total_results / $limit_per_page) : ceil($total_results / $total_results);
    }
    public function getLinkList()
    {
        $last = $this->getTotalPages();
        $pagination_links_limit = $this->getPaginationLinksLimit();
        $page_number = $this->getPageNumber();
        $url = $this->getPageUrl();
        $pagination = [];
        $start = (($page_number - $pagination_links_limit) > 0) ? $page_number - $pagination_links_limit : 1;
        $end = (($page_number + $pagination_links_limit) < $last) ? $page_number + $pagination_links_limit : $last;
        $counter = 0;
        if ($page_number > $start)
        {
            $pagination[$counter]["name"] = '« Previous';
            $pagination[$counter]["url"] = $url . ($page_number - 1);
            $counter++;
        }
        if ($start > 1)
        {
            $pagination[$counter]["name"] = '1';
            $pagination[$counter]["url"] = $url;
            $pagination[$counter]["span_name"] = '...';
            $pagination[$counter]["span_position"] = 'append';
            $counter++;
        }
        for ($i = $start;$i <= $end;$i++)
        {
            $pagination[$counter]["li_class"] = ($page_number == $i) ? "disabled" : "";
            $pagination[$counter]["a_class"] = ($page_number == $i) ? "active" : "";
            $pagination[$counter]["name"] = $i;
            $pagination[$counter]["url"] = $url . $i;
            $counter++;
        }
        if ($end < $last)
        {
            $pagination[$counter]["name"] = $last;
            $pagination[$counter]["url"] = $url . $last;
            $pagination[$counter]["span_name"] = '...';
            $pagination[$counter]["span_position"] = 'prepend';
            $counter++;
        }

        if ($page_number < $last)
        {
            $pagination[$counter]["name"] = 'Next »';
            $pagination[$counter]["url"] = $url . ($page_number + 1);
        }
        return $pagination;
    }
    public function getPagination()
    {
        $link_list = $this->getLinkList();
        $inner_data = '';
        foreach ($link_list as $data)
        {
            $li_class = isset($data["li_class"]) ? $data["li_class"] : '';
            $a_class = isset($data["a_class"]) ? $data["a_class"] : '';
            $url = isset($data["url"]) ? $data["url"] : '';
            $name = isset($data["name"]) ? $data["name"] : '';
            $span_name = isset($data["span_name"]) ? $data["span_name"] : '';
            if (isset($data["span_position"]) && $data["span_position"] == "prepend") $inner_data .= '<li><span>' . $span_name . '</span></li>';
            $inner_data .= '<li class="' . $li_class . '">';
            $inner_data .= '<a class="pms-nav-footer ' . $a_class . '" href="' . $url . '">';
            $inner_data .= $name;
            $inner_data .= '</a></li>';
            if (isset($data["span_position"]) && $data["span_position"] == "append") $inner_data .= '<li><span>' . $span_name . '</span></li>';
        }
        $html = '<div class="' . $this->getPaginationClasses() . '">';
        $html .= '<ul class="fx-row justify-center">';
        $html .= $inner_data;
        $html .= '</ul>';
        $html .= '</div>';

        return $html;
    }

}

?>
