<?PHP


Class Prices
{
	var $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function get($key)
	{
		$query = $this->CI->db->get_where('prices', array('key' => $key))->row_array();
		
		return $query['value'];
	}
}