<?php

namespace EduCat\Controllers;

use EduCat\Models\{
    User,
    Metadata,
    Contact
};

use EduCat\Core\{
    App,
    Contrib\Flash,
    Http\Request
};

use EduCat\Core\Http\Controller;

class SettingsController extends Controller
{
    public $app_name = 'settings';
    public Metadata $Metadata;
    public Contact $Contact;

    public function __construct()
    {
        $this->Metadata = App::get('factory')->make('Metadata');
        $this->Contact = App::get('factory')->make('Contact');

        // Metadata
        if (!$this->Metadata->exists('title')) {
            $this->Metadata->create_default('title');
        }
        if (!$this->Metadata->exists('description')) {
            $this->Metadata->create_default('description');
        }
        if (!$this->Metadata->exists('keywords')) {
            $this->Metadata->create_default('keywords');
        }

        // Contact
        if (!$this->Contact->exists('school_name')) {
            $this->Contact->create_default('school_name');
        }
        if (!$this->Contact->exists('address')) {
            $this->Contact->create_default('address');
        }
        if (!$this->Contact->exists('city')) {
            $this->Contact->create_default('city');
        }
        if (!$this->Contact->exists('postal_code')) {
            $this->Contact->create_default('postal_code');
        }
        if (!$this->Contact->exists('phone_number')) {
            $this->Contact->create_default('phone_number');
        }
    }

    public function index()
    {
        User::ensure_admin();
        // Metadata
        $title = $this->Metadata->select_where(["_key" => "title"])[0]->_value;
        $description = $this->Metadata->select_where(["_key" => "description"])[0]->_value;
        $keywords = $this->Metadata->select_where(["_key" => "keywords"])[0]->_value;

        // Contact
        $school_name = $this->Contact->select_where(["_key" => "school_name"])[0]->_value;
        $address = $this->Contact->select_where(["_key" => "address"])[0]->_value;
        $city = $this->Contact->select_where(["_key" => "city"])[0]->_value;
        $postal_code = $this->Contact->select_where(["_key" => "postal_code"])[0]->_value;
        $phone_number = $this->Contact->select_where(["_key" => "phone_number"])[0]->_value;
        return $this->render('index', compact('title', 'description', 'keywords', 'school_name', 'address', 'city', 'postal_code', 'phone_number'));
    }

    public function get_post_data()
    {
        User::ensure_admin();
        $data = Request::data();

        $metadata_keys = ["title", "description", "keywords"];
        $new_metadata_data = array_filter($data, function ($prop) use ($metadata_keys) {
            return in_array($prop, $metadata_keys);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($new_metadata_data as $key => $value) {
            if (empty($value)) {
                Flash::error("Values can't be empty.");
                return redirect("/admin/settings");
            }
            $this->Metadata->update_where(["_value" => $value], ["_key" => $key]);
        }

        $contact_keys = ["school_name", "address", "city", "postal_code", "phone_number"];
        $new_contact_data = array_filter($data, function ($prop) use ($contact_keys) {
            return in_array($prop, $contact_keys);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($new_contact_data as $key => $value) {
            if (empty($value)) {
                Flash::error("Values can't be empty.");
                return redirect("/admin/settings");
            }
            $this->Contact->update_where(["_value" => $value], ["_key" => $key]);
        }

        Flash::success("Settings have been updated.");
        return redirect("/admin/settings");
    }
}
