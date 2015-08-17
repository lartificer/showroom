<?php namespace Lartificer\News\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Lartificer\News\Models\News;
use Lartificer\News\Models\NewsTranslation;

class NewsController extends Controller {

    /**
     * The supported languages. The first one is always the fallback if no other can be set.
     *
     * @var array
     */
    protected $languages = ['en', 'de', 'fr'];

    /**
     * The constructor searches for an already set locale. If none is found, set the default locale.
     */
    public function __construct() {

        if(!Session::has('locale')) {
            Session::put('locale', $this->languages[0]);
        }

        app()->setLocale(Session::get('locale'));

    }

    /**
     * The function returns an overview of all the visible and not yet deleted news entries ordered by their date of creation.
     *
     * @return \Illuminate\View\View
     */
    public function getNewsOverview() {

        if(Auth::check()) {

            // Get all the news entries that are not deleted and show 20 per page.
            $newsEntries = News::orderBy('created_at', 'desc')
                ->where('deleted_at', '=', null)
                ->paginate(20);

            // Retrieve the locale to fetch the fitting translations and add it to the results
            $translations = [];
            $locale = app()->getLocale();

            foreach($newsEntries as $index => $entry) {

                $translation = NewsTranslation::where('news_id', '=', $entry->id)
                    ->where('language', 'LIKE', $locale)
                    ->first();

                $translations[$index] = $translation;

            }

        } else {

            // Get all the news entries that are visible and got not deleted so far.
            $newsEntries = News::orderBy('created_at', 'desc')
                ->where('visible', '=', true)
                ->where('deleted_at', '=', null)
                ->paginate(10);

            // Retrieve the locale to fetch the fitting translations and add it to the results
            $translations = [];
            $locale = app()->getLocale();
            foreach($newsEntries as $index => $entry) {

                $translation = NewsTranslation::where('news_id', '=', $entry->id)
                    ->where('language', 'LIKE', $locale)
                    ->first();

                $translations[$index] = $translation;

            }

        }

        return view("news::overview", [
            'newsEntries' => $newsEntries,
            'translations' => $translations
        ]);

    }

    /**
     * The function returns the view to create a new news entry.
     *
     * @return \Illuminate\View\View
     */
    public function getCreateNewsEntry() {
        return view("news::create");
    }

    /**
     * The function saves the news entry if the user is authenticated to do so. Otherwise the user is redirected back to the overview page with an error.
     *
     * @return mixed
     */
    public function postCreateNewsEntry() {

        // Check if the user is authenticated.
        if(\Auth::check()) {

            // Get the input data
            $data = \Input::only('title', 'content', 'visible');

            // Set the right visibility
            if($data['visible'] != null) {
                $visibility = true;
            } else {
                $visibility = false;
            }

            // Create the news entry and according to that a new translation
            $newsEntry = News::create([
                'visible' => $visibility,
                'user_id' => \Auth::user()->id,
            ]);
            $localeEntry = NewsTranslation::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'slug' => str_slug($data['title']),
                'news_id' => $newsEntry->id,
                'language' => app()->getLocale(),
            ]);

            \Session::flash('message', trans('news::messages.successfully_created'));
            \Session::flash('message-class', 'success-message');

            return \Redirect::to(trans('news::links.overview'));

        }

        \Session::flash('message', trans('news::messages.insufficient_permissions'));
        \Session::flash('message-class', 'error-message');

        return \Redirect::to(trans('news::link.overview'));

    }

    /**
     * The function saves the input data to the news entry if it exists.
     *
     * @param $id
     */
    public function postUpdateNewsEntry($id) {

        if(\Auth::check()) {

            // Get the input data
            $json = \Input::json();
            $type = $json->get('Type');
            $data = $json->get('Content');

            // Retrieve the news entry from the given id
            $newsEntry = News::findOrFail($id);

            // Get the locale and the fitting news translation of the news entry above
            $locale = app()->getLocale();

            $localeEntry = $newsEntry
            ->newsTranslations()
            ->where('language', 'LIKE', $locale)
                ->first();

            // Save the localeEntry. Either only the headline or only the content
            if($type == 'headline') {

                $localeEntry->title = $data;
                $localeEntry->slug = str_slug($data);
                $localeEntry->save();

            } else {

                $localeEntry->content = $data;
                $localeEntry->save();

            }

        }

    }

    /**
     * The function deletes the news entry with the id given as input parameter and redirects the user back
     *
     * @param $id
     * @return mixed
     */
    public function deleteNewsEntry($id) {

        if(\Auth::check()) {

            News::findOrFail($id)->delete();
            //NewsTranslation::where('news_id', '=', $id)->delete();

            \Session::flash('message', trans('news::messages.successfully_deleted'));
            \Session::flash('message-class', 'success-message');

            return \Redirect::back();

        }

        \Session::flash('message', trans('news::messages.insufficient_permissions'));
        \Session::flash('message-class', 'error-message');

        return \Redirect::back();

    }

    /**
     * The function toggles the visibility of a news entry
     *
     */
    public function toggleVisibility() {

        if(Auth::check()) {

            $input = \Input::json();
            $id = $input->get('Id');

            if($input->get('Visibility') == 'true') {
                $visibility = true;
            } else {
                $visibility = false;
            }

            $entry = News::findOrFail($id);
            $entry->visible = $visibility;
            $entry->save();

        }

    }
}