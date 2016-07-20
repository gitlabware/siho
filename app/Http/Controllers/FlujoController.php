<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateFlujoRequest;
use App\Http\Requests\UpdateFlujoRequest;
use App\Repositories\FlujoRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class FlujoController extends InfyOmBaseController
{
    /** @var  FlujoRepository */
    private $flujoRepository;

    public function __construct(FlujoRepository $flujoRepo)
    {
        $this->flujoRepository = $flujoRepo;
    }

    /**
     * Display a listing of the Flujo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->flujoRepository->pushCriteria(new RequestCriteria($request));
        $flujos = $this->flujoRepository->all();

        return view('flujos.index')
            ->with('flujos', $flujos);
    }

    /**
     * Show the form for creating a new Flujo.
     *
     * @return Response
     */
    public function create()
    {
        return view('flujos.create');
    }

    /**
     * Store a newly created Flujo in storage.
     *
     * @param CreateFlujoRequest $request
     *
     * @return Response
     */
    public function store(CreateFlujoRequest $request)
    {
        $input = $request->all();

        $flujo = $this->flujoRepository->create($input);

        Flash::success('Flujo saved successfully.');

        return redirect(route('flujos.index'));
    }

    /**
     * Display the specified Flujo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $flujo = $this->flujoRepository->findWithoutFail($id);

        if (empty($flujo)) {
            Flash::error('Flujo not found');

            return redirect(route('flujos.index'));
        }

        return view('flujos.show')->with('flujo', $flujo);
    }

    /**
     * Show the form for editing the specified Flujo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $flujo = $this->flujoRepository->findWithoutFail($id);

        if (empty($flujo)) {
            Flash::error('Flujo not found');

            return redirect(route('flujos.index'));
        }

        return view('flujos.edit')->with('flujo', $flujo);
    }

    /**
     * Update the specified Flujo in storage.
     *
     * @param  int              $id
     * @param UpdateFlujoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFlujoRequest $request)
    {
        $flujo = $this->flujoRepository->findWithoutFail($id);

        if (empty($flujo)) {
            Flash::error('Flujo not found');

            return redirect(route('flujos.index'));
        }

        $flujo = $this->flujoRepository->update($request->all(), $id);

        Flash::success('Flujo updated successfully.');

        return redirect(route('flujos.index'));
    }

    /**
     * Remove the specified Flujo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $flujo = $this->flujoRepository->findWithoutFail($id);

        if (empty($flujo)) {
            Flash::error('Flujo not found');

            return redirect(route('flujos.index'));
        }

        $this->flujoRepository->delete($id);

        Flash::success('Flujo deleted successfully.');

        return redirect(route('flujos.index'));
    }
}
