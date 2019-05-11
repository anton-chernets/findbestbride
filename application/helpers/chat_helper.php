<?PHP
	function createSimplePagination($total, $page, $function, $num_links = 5, $arguments = '')
    {        
        if ($page <= 0)
        {
            $page = 1;
        }
        
        //всего страниц
        $count_links = ceil($total / $num_links);
        
        //
        $pagination = '<span>';
        
        if ($page > 1)
        {
            $pagination .= '<a href="javascript:;" onClick="'.$function.'('.($page - 1). $arguments.');"><i><</i></a>';
        }
        
        if ($count_links > 1)
        {
            if ($count_links <= $num_links)
            {
                $start = 1;
                $end = $count_links;
            }
            else
            {
                $start = $page - floor($num_links / 2);
                $end = $page + floor($num_links / 2);
                
                if ($start < 1)
                {
                    $end += abs($start) + 1;
                    $start = 1;
                }
                
                if ($end > $count_links)
                {
                    $start -= ($end - $count_links); 
                    $end = $count_links; 
                }
            }
            
            for ($i = $start; $i <= $end; $i++)
            {
                if ($page == $i)
                {
                    $pagination .= '<a class="userpageactive">'.$i.'</a>';
                }
                else
                {
                    $pagination .= '<a href="javascript:;" onClick="'.$function.'('.$i.$arguments.');"><i>'.$i.'</i></a>';
                }
            }
        }
        
        if ($page < $count_links)
        {
            $pagination .= '<a href="javascript:;" onClick="'.$function.'('.($page + 1).$arguments.');"><i>></i></a>';
        }
        
        $pagination .= '</span>';
        
        if ($count_links > 1)
        {
            return $pagination;
        }
        
        return false;
    }