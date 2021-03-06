<?php

/* Copyright 2016 by Alexander Watzinger and others. Please see the file README.md for licensing information */

class Admin_SourceControllerTest extends ControllerTestCase {

    private $formValues = [
        'name' => 'source',
        'description' => 'description'
    ];

    public function setUp() {
        parent::setUp();
        $this->login();
        $type = Model_NodeMapper::getByNodeCategoryName('source', 'letter');
        $this->formValues['sourceId'] = $type->id;
    }

    public function testAdd() {
        $this->dispatch('admin/source/add/id/' . $this->actorId);
        $this->request->setMethod('POST')->setPost(['' => $this->sourceId ]);
        $this->dispatch('admin/source/add/id/' . $this->actorId);
        $this->resetRequest()->resetResponse();
        $this->dispatch('admin/source/view/id/' . $this->sourceId);
    }

    public function testAdd2() {
        $this->dispatch('admin/source/add2/type/actor/id/' . $this->sourceId);
        $this->request->setMethod('POST')->setPost([0 => $this->actorId, 1 => $this->eventId]);
        $this->dispatch('admin/source/add2/type/actor/id/' . $this->sourceId);
    }

    public function testCrud() {
        $this->dispatch('admin/source/insert/code/E33');
        $this->resetRequest()->resetResponse();
        $this->request->setMethod('POST')->setPost($this->formValues);
        $this->dispatch('admin/source/insert/code/E33/eventId/' . $this->eventId);
        $this->resetRequest()->resetResponse();
        $this->request->setMethod('POST')->setPost($this->formValues);
        $this->dispatch('admin/source/insert/code/E33/actorId/' . $this->actorId);
        $this->resetRequest()->resetResponse();
        $this->request->setMethod('POST')->setPost($this->formValues);
        $this->dispatch('admin/source/insert/code/E33/objectId/' . $this->placeId);
        $this->resetRequest()->resetResponse();
        // test insert with continue
        $this->formValues['continue'] = 1;
        $this->request->setMethod('POST')->setPost($this->formValues);
        $this->dispatch('admin/source/insert/code/E33');
        $this->resetRequest()->resetResponse();
        $this->request->setMethod('POST')->setPost($this->formValues);
        $this->dispatch('admin/source/insert/code/E33/eventId/' . $this->eventId);
        $this->resetRequest()->resetResponse();
        $this->request->setMethod('POST')->setPost($this->formValues);
        $this->dispatch('admin/source/insert/code/E33/actorId/' . $this->actorId);
        $this->resetRequest()->resetResponse();
        $this->request->setMethod('POST')->setPost($this->formValues);
        $this->dispatch('admin/source/insert/code/E33/objectId/' . $this->placeId);
        $this->resetRequest()->resetResponse();
        $this->dispatch('admin/source');
        $this->dispatch('admin/source/update/id/' . $this->sourceId);
        $this->request->setMethod('POST')->setPost($this->formValues);
        $this->dispatch('admin/source/update/id/' . $this->sourceId);
        $this->resetRequest()->resetResponse();
        $this->formValues['name'] = '';
        $this->request->setMethod('POST')->setPost($this->formValues);
        $this->dispatch('admin/source/update/id/' . $this->sourceId); // test invalid form
        $this->resetRequest()->resetResponse();
        $this->dispatch('admin/source/delete/id/' . $this->sourceId);
    }

    public function testText() {
        $original = Model_NodeMapper::getByNodeCategoryName('Linguistic object classification', 'Source Original Text');
        $this->dispatch('admin/source/text-add/id/' . $this->sourceId);
        $this->resetRequest()->resetResponse();
        $formValues = ['type' => $original->id, 'name' => 'original', 'description' => 'description'];
        $this->request->setMethod('POST')->setPost($formValues);
        $this->dispatch('admin/source/text-add/id/' . $this->sourceId);
        $this->resetRequest()->resetResponse();
        $textLink = Model_LinkMapper::getLink($this->sourceId, 'P73');
        $this->dispatch('admin/source/text-update/linkId/' . $textLink->id);
        $this->resetRequest()->resetResponse();
        $this->request->setMethod('POST')->setPost($formValues);
        $this->dispatch('admin/source/text-update/linkId/' . $textLink->id);
        $this->resetRequest()->resetResponse();
        $this->dispatch('admin/source/text-delete/linkId/' . $textLink->id);
    }

}
