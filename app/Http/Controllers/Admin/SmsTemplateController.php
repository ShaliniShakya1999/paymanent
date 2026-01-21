<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Common;

class SmsTemplateController extends Controller
{
    public function index($alias = null)
    {
        $data['menu']      = 'templates';
        $data['sub_menu']  = 'sms_template';

        $data['smsTemplates'] = [];
        EmailTemplate::where(['type' => 'sms', 'status' => 'Active'])
                ->get(['id', 'name', 'alias', 'type', 'lang', 'group', 'status'])
                ->map(function($templates) use (&$data) {
                    return $data['smsTemplates'][$templates->group][$templates->name][$templates->lang] = $templates;
                });

        // Safely get default template alias if not provided
        $defaultAlias = null;
        if (isset($data['smsTemplates']['General']['Address or Identity Verification']['en']['alias'])) {
            $defaultAlias = $data['smsTemplates']['General']['Address or Identity Verification']['en']['alias'];
        } else {
            // Fallback: get first available template alias
            $firstTemplate = EmailTemplate::where(['type' => 'sms', 'status' => 'Active'])->first();
            $defaultAlias = $firstTemplate ? $firstTemplate->alias : null;
        }
        
        $data['templateAlias'] = $alias ?? $defaultAlias;
        $data['templateData'] = EmailTemplate::where(['type' => 'sms', 'status' => 'Active', 'alias' => $data['templateAlias']])->get(['id', 'subject', 'body']);

        return view('admin.sms_templates.index', $data);
    }

    public function update(Request $request, $alias)
    {
        $data[] = $request->en;
        $data[] = $request->ar;
        $data[] = $request->fr;
        $data[] = $request->pt;
        $data[] = $request->ru;
        $data[] = $request->es;
        $data[] = $request->tr;
        $data[] = $request->ch;

        $array = $data;

        array_unshift($array, "");

        unset($array[0]);

        for ($i = 1; $i < 9; $i++)
        {
            EmailTemplate::where([
                'alias'     => $alias,
                'type'     => 'sms',
                'language_id' => $i,
            ])->update($array[$i]);
        }

        (new Common())->one_time_message('success', __('The :x has been successfully saved.', ['x' => __('sms template')]));
        return redirect()->route('sms.template.index', $alias);
    }
}
