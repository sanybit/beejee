<?php
class Pagination
{
	// Метод возвращает строку пагинации
	public static function linkPagination($page, $pagesCount, $sort) {
		
		
		$active = '';
		if($page == 1) $active = " active-page";
		$page1 = $page - 1;
		if($page1 <= 0) $page1 = 1;
		
		$viewPagination = "
			<div class='pagination-container'>
				<form class='pagination-form' action='".ROOT_HTML."task/".$page1."' method='POST'>
					<input type='hidden' name='sort' value='".$sort."'>
					<input type='submit' name='pBtn' value='<' class='pagination-link'>
				</form>
			</div>
			<div class='pagination-container".$active."'>
				<form class='pagination-form' action='".ROOT_HTML."task/1' method='POST'>
					<input type='hidden' name='sort' value='".$sort."'>
					<input type='submit' name='pBtn' value='1..' class='pagination-link'>
				</form>
			</div>
		";
		
		$i1 = $page - 2;
		if($page <= 3) $i1 = 2;
		
		for($i = $i1; $i < $pagesCount; $i++) {
			
			if($i >= ($page + 3)) break;
			
			$active = '';
			if($page == $i) $active = " active-page";
			
			$viewPagination = $viewPagination."
				<div class='pagination-container".$active."'>
					<form class='pagination-form' action='".ROOT_HTML."task/".$i."' method='POST'>
					  <input type='hidden' name='sort' value='".$sort."'>
					  <input type='submit' name='pBtn' value='".$i."' class='pagination-link'>
					</form>
				</div>
			";
		}
		
		$active = '';
		if($page == $pagesCount) $active = " active-page";
		$page2 = $page + 1;
		if($page2 >= $pagesCount) $page2 = $pagesCount;
		
		$viewPagination = $viewPagination."
			<div class='pagination-container".$active."'>
				<form class='pagination-form' action='".ROOT_HTML."task/".$pagesCount."' method='POST'>
					<input type='hidden' name='sort' value='".$sort."'>
					<input type='submit' name='pBtn' value='..".$pagesCount."' class='pagination-link'>
				</form>
			</div>
			<div class='pagination-container'>
				<form class='pagination-form' action='".ROOT_HTML."task/".$page2."' method='POST'>
					<input type='hidden' name='sort' value='".$sort."'>
					<input type='submit' name='pBtn' value='>' class='pagination-link'>
				</form>
			</div>
		";
		
		return $viewPagination;
	}
}
?>