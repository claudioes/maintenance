<?php 

namespace Stevebauman\Maintenance\Controllers;

use Dmyers\Storage\Storage;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Stevebauman\Maintenance\Services\AttachmentService;

class AttachmentController extends BaseController {
	
	public function __construct(AttachmentService $attachment){
		$this->attachment = $attachment;
	}
	
	public function destroy($attachment_id){
		if(Request::ajax()){
			$attachment = $this->attachment->find($attachment_id);
			if($attachment){
				if(Storage::delete($attachment->file_path.$attachment->file_name)){
					rmdir(config('path.storage').$attachment->file_path);
					$attachment->delete();
					
					return Response::json(array(
						'message'=>'Successfully deleted attachment',
						'messageType' => 'success'
					));
				} else{
					return Response::json(array(
						'message'=>'Error deleting attachment',
						'messageType' => 'error'
					));
				}
			}
		}
	}
}