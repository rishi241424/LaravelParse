<?php

namespace App\Http\Controllers;

use App\Companies;
use App\Details;
use App\Industries;
use DB;
use Goutte\Client;

class MyController extends Controller
{
    public function getIndustries()
    {
        $client = new Client();
        $industries = [];
        $data = [];
        $crawler = $client->request('GET', 'http://mycorporateinfo.com/industry');
        $crawler->filter('li.list-group-item')->each(function ($node) use (&$industries, &$data) {
            $industries[]['industries'] = $node->text();
            $data[] = $node->text();
        });
        if ($industries) {
            Industries::truncate();
            if (DB::table('industries')->insert($industries)) {
                return response()->json(['error' => false, 'industries' => $data], 200);
            }
            return response()->json(['error' => true, 'msg' => 'Something went wrong'], 200);
        }
        return response()->json(['error' => true, 'msg' => 'No Data found to import'], 200);
    }
    public function getSections()
    {
        $client = new Client();
        $data = [];
        $crawler = $client->request('GET', 'http://mycorporateinfo.com/industry/section/F');
        $crawler->filter('table tr td')->each(function ($node) use (&$data) {
            $data[] = $node->text();
        });
        if ($data) {
            $data = array_chunk($data, 4);
            Companies::truncate();
            foreach ($data as $k => $rows) {
                $finalData[$k]['cin'] = $rows[0];
                $finalData[$k]['company_name'] = $rows[1];
                $finalData[$k]['class'] = $rows[2];
                $finalData[$k]['status'] = $rows[3];
            }
            if (DB::table('companies')->insert($finalData)) {
                return response()->json(['error' => false, 'companies' => $finalData], 200);
            }
            return response()->json(['error' => true, 'msg' => 'Something went wrong'], 200);
        }
        return response()->json(['error' => true, 'msg' => 'No Data found to import'], 200);
    }
    public function getDetail()
    {
        $client = new Client();
        $data = [];
        $crawler = $client->request('GET', 'http://mycorporateinfo.com/business/shilpi-builders-limited-1');
        $details = new Details();
        $description = $crawler->filter('.main_test')->children('p');
        $details->description = $description->html();
        $details->company_information = $crawler->filter('#companyinformation')->html();
        $details->company_detail = $crawler->filter('#contactdetails')->html();
        $details->listingandannualcomplaincedetails = $crawler->filter('#listingandannualcomplaincedetails')->html();
        $details->otherinformation = $crawler->filter('#otherinformation')->html();
        $details->faq = $crawler->filter('#faq')->html();
        Details::truncate();
        if ($details->save()) {
            return response()->json(['error => false', 'data' => $details], 200);
        }
        return response()->json(['error' => true, 'msg' => 'Something went wrong'], 200);
    }
}
