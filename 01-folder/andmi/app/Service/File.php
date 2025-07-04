<?php

namespace App\Service;

use App\Http\Requests\Student\StoreAchievementRequest;
use App\Http\Requests\Student\StoreArticleRequest;
use App\Http\Requests\Student\StoreDistinguishedScholarshipRequest;
use App\Http\Requests\Student\StoreGrandEconomyRequest;
use App\Http\Requests\Student\StoreInventionRequest;
use App\Http\Requests\Student\StoreLangCertificateRequest;
use App\Http\Requests\Student\StoreOlympicRequest;
use App\Http\Requests\Student\StoreScholarshipRequest;
use App\Http\Requests\Student\StoreStartupRequest;
use App\Http\Requests\Teacher\StoreTaskRequest;
use App\Models\File\Achievement;
use App\Models\File\Article;
use App\Models\File\DistinguishedScholarship;
use App\Models\File\GrandEconomy;
use App\Models\File\Invention;
use App\Models\File\LangCertificate;
use App\Models\File\Olympic;
use App\Models\File\Scholarship;
use App\Models\File\Startup;
use App\Models\File\Task;
use Illuminate\Http\Request;

class File
{
    protected $request;

    protected $user;

    public function __construct()
    {}

    public function user(Request $request)
    {
        $this->request = $request;
        $this->user = $request->user();

        return $this;
    }

    public function article(StoreArticleRequest $request)
    {
        $data = $request->validated();

        $article = new Article;
        $article->user_id = $this->user->id;
        $article->criteria_id = $data['criteria_id'];
        $article->education_year_id = $data['education_year'];
        $article->title = $data['title'];
        $article->keywords = $data['keywords'];
        $article->lang = $data['lang'];
        $article->authors_count = $data['authors_count'];
        $article->authors = $data['authors'];
        $article->doi = $data['doi'];
        $article->journal_name = $data['journal_name'];
        $article->publish_params = $data['publish_params'];
        $article->international_databases = $data['international_databases'];
        $article->published_year = $data['published_year'];
        $article->save();

        $article->upload_file($request, 'articles');

        return $article;
    }

    public function scholarship(StoreScholarshipRequest $request)
    {
        $data = $request->validated();

        $scholarship = new Scholarship;
        $scholarship->user_id = $this->user->id;
        $scholarship->criteria_id = $data['criteria_id'];
        $scholarship->title = $data['title'];
        $scholarship->given_date = $data['given_date'];
        $scholarship->certificate_number = $data['certificate_number'];
        $scholarship->save();

        $scholarship->upload_file($request, 'scholarships');

        return $scholarship;
    }

    public function invention(StoreInventionRequest $request)
    {
        $data = $request->validated();

        $invention = new Invention;

        $invention->user_id = $this->user->id;
        $invention->criteria_id = $data['criteria_id'];
        $invention->education_year_id = $data['education_year'];
        $invention->title = $data['title'];
        $invention->property_number = $data['property_number'];
        $invention->authors_count = $data['authors_count'];
        $invention->authors = $data['authors'];
        $invention->publish_params = $data['publish_params'];
        $invention->save();

        $invention->upload_file($request, 'inventions');

        return $invention;
    }

    public function startup(StoreStartupRequest $request)
    {
        $data = $request->validated();

        $startup = new Startup;

        $startup->user_id = $this->user->id;
        $startup->criteria_id = $data['criteria_id'];
        $startup->title = $data['title'];
        $startup->type = $data['type'];
        $startup->participant = $data['participant'];
        $startup->team_members = $data['team_members'];
        $startup->location_id = $data['location_id'];
        $startup->save();

        $startup->upload_file($request, 'startups');

        return $startup;
    }

    public function grand_economy(StoreGrandEconomyRequest $request)
    {
        $data = $request->validated();

        $grand_economy = new GrandEconomy;

        $grand_economy->user_id = $this->user->id;
        $grand_economy->criteria_id = $data['criteria_id'];
        $grand_economy->title = $data['title'];
        $grand_economy->order_number = $data['order_number'];
        $grand_economy->amount = $data['amount'];
        $grand_economy->save();

        $grand_economy->upload_file($request, 'grand_economies');

        return $grand_economy;
    }

    public function olympics(StoreOlympicRequest $request)
    {
        $data = $request->validated();

        $olympic = new Olympic;

        $olympic->user_id = $this->user->id;
        $olympic->criteria_id = $data['criteria_id'];
        $olympic->date = $data['date'];
        $olympic->direction = $data['direction'];
        $olympic->save();

        $olympic->upload_file($request, 'olympics');

        return $olympic;
    }

    public function lang_certificate(StoreLangCertificateRequest $request)
    {
        $data = $request->validated();

        $certificate = new LangCertificate;
        $certificate->user_id = $this->user->id;
        $certificate->criteria_id = $data['criteria_id'];
        $certificate->lang = $data['lang'];
        $certificate->type = $data['type'];
        $certificate->given_date = $data['given_date'];
        $certificate->save();

        $certificate->upload_file($request, 'lang_certificates');

        return $certificate;
    }

    public function distinguished_scholarship(StoreDistinguishedScholarshipRequest $request)
    {
        $data = $request->validated();

        $scholarship = new DistinguishedScholarship;
        $scholarship->user_id = $this->user->id;
        $scholarship->save();

        $files = [
            'reference',
            'passport',
            'rating_book',
            'dean_guarantee',
            'dean_recommendation',
            'faculty_statement',
            'department_recommendation',
            'supervisor_conclusion',
            'list_of_works',
            'certificates',
        ];

        foreach ($files as $file) {
            $scholarship->upload_file($request, 'distinguished_scholarships', $file);
        }

        return $scholarship;
    }

    public function achievement(StoreAchievementRequest $request)
    {
        $data = $request->validated();

        $achievement = new Achievement;

        $achievement->user_id = $this->user->id;
        $achievement->criteria_id = $data['criteria_id'];
        $achievement->type = $data['type'];
        $achievement->participant = $data['participant'];
        $achievement->team_members = $data['team_members'];
        $achievement->location_id = $data['location_id'];
        $achievement->document_type = $data['document_type'];
        $achievement->save();

        $achievement->upload_file($request, 'achievements');

        return $achievement;
    }

    public function task(StoreTaskRequest $request)
    {
        $data = $request->validated();

        $task = new Task;

        $task->employee_id = $this->user->employee->id;
        $task->student_id = $data['student_id'];
        $task->title = $data['title'];
        $task->description = $data['description'];
        $task->save();

        $task->upload_file($request, 'tasks');

        return $task;
    }

    public function destroy_article($id)
    {
        $article = Article::findOrFail($id);
        $article->file()->delete();

        return $article->delete();
    }

    public function destroy_scholarship($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->file()->delete();

        return $scholarship->delete();
    }

    public function destroy_invention($id)
    {
        $invention = Invention::findOrFail($id);
        $invention->file()->delete();

        return $invention->delete();
    }

    public function destroy_startup($id)
    {
        $startup = Startup::findOrFail($id);
        $startup->file()->delete();

        return $startup->delete();
    }

    public function destroy_grand_economy($id)
    {
        $grand_economy = GrandEconomy::findOrFail($id);
        $grand_economy->file()->delete();

        return $grand_economy->delete();
    }

    public function destroy_olympics($id)
    {
        $olympic = Olympic::findOrFail($id);
        $olympic->file()->delete();

        return $olympic->delete();
    }

    public function destroy_lang_certificate($id)
    {
        $certificate = LangCertificate::findOrFail($id);
        $certificate->file()->delete();

        return $certificate->delete();
    }

    public function destroy_distinguished_scholarship($id)
    {
        $scholarship = DistinguishedScholarship::findOrFail($id);
        $scholarship->file()->delete();

        return $scholarship->delete();
    }

    public function destroy_achievement($id)
    {
        $achievement = Achievement::findOrFail($id);
        $achievement->file()->delete();

        return $achievement->delete();
    }

    public function destroy_task($id)
    {
        $task = Task::findOrFail($id);
        $task->file()->delete();

        return $task->delete();
    }
}
