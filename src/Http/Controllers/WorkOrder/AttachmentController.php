<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder;

use Stevebauman\Maintenance\Http\Requests\AttachmentRequest;
use Stevebauman\Maintenance\Repositories\WorkOrder\AttachmentRepository;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository as WorkOrderRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

class AttachmentController extends BaseController
{
    /**
     * @var WorkOrderRepository
     */
    protected $workOrder;

    /**
     * @var AttachmentRepository
     */
    protected $attachment;

    /**
     * Constructor.
     *
     * @param WorkOrderRepository $workOrder
     * @param AttachmentRepository $attachment
     */
    public function __construct(WorkOrderRepository $workOrder, AttachmentRepository $attachment)
    {
        $this->workOrder = $workOrder;
        $this->attachment = $attachment;
    }

    /**
     * Displays a list of the work order attachments.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $workOrder = $this->workOrder->find($id);

        return view('maintenance::work-orders.attachments.index', compact('workOrder'));
    }

    /**
     * Displays the form to create work order attachments.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        $workOrder = $this->workOrder->find($id);

        return view('maintenance::work-orders.attachments.create', compact('workOrder'));
    }

    /**
     * Processes storing the attachment record.
     *
     * @param AttachmentRequest $request
     * @param int|string        $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AttachmentRequest $request, $id)
    {
        $workOrder = $this->workOrder->find($id);

        $uploads = $this->attachment->uploadForWorkOrder($request, $workOrder);

        if($uploads) {
            $message = 'Successfully uploaded files.';

            return redirect()->route('maintenance.work-orders.attachments.index', [$workOrder->id])->withSuccess($message);
        } else {
            $message = 'There was an issue uploaded the files you selected. Please try again.';

            return redirect()->route('maintenance.work-orders.attachments.create', [$id])->withErrors($message);
        }
    }

    /**
     * Processes deleting an attachment record and the file itself.
     *
     * @param int|string $id
     * @param int|string $attachmentId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, $attachmentId)
    {
        $workOrder = $this->workOrder->find($id);

        $attachment = $this->attachment->find($attachmentId);

        if($attachment->delete()) {
            $message = 'Successfully deleted attachment.';

            return redirect()->route('maintenance.work-orders.attachments.index', [$workOrder->id])->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this attachment. Please try again.';

            return redirect()->route('maintenance.work-orders.attachments.show', [$workOrder->id, $attachment->id])->withErrors($message);
        }
    }

    /**
     * Prompts the user to download the specified uploaded file.
     *
     * @param int|string $id
     * @param int|string $attachmentId
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id, $attachmentId)
    {
        $workOrder = $this->workOrder->find($id);

        $attachment = $workOrder->attachments()->find($attachmentId);

        return response()->download($attachment->download_path);
    }
}
