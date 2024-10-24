<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Devsinc</title>

        @include('partials._head')
    </head>
<x-app-layout>
    <body class="my-5">
        <div class="container-fluid container">
            <div class="row">
                <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                    <h3 class="text-primary text-center mb-3">Privacy Policy</h3>
                    <div class="col-lg-12">
                        <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">What is Devsinc?</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Our goal is to connect veterinary professionals to increase productivity and socialization. We pride ourselves on being open and honest about the information we collect about you, how we use it, and with whom we share it.</p>
                            <p>Our privacy policy will specify how we share, use, and collect information. Our policy applies to all Devsinc services. Most importantly, we believe in confidentiality and are committed to being open and honest about privacy concerns, including how to secure information.</p>
                        </div>
                        </div>
                        <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Data We Collect</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>We collect the information you provide, like registration information, profile data, and post uploads. The activities and information you provide are all collected, such as: </p>
                            <p>Content you create, like posts, comments, audio or video </p>
                            <p>Messages you send and receive, including their content (end-to-end encrypted unless reported) </p>
                            <p>Kinds of content you view or interact with, and how you interact with it </p>
                            <p>Apps and features you use, and actions you take in them. </p>
                            <p>Hashtags you use</p>
                            <p>The time, frequency, and duration of your activities on our portal </p>
                            <p>Information about friends, followers, groups, accounts, pages, and communities you’re connected to and interact with.</p>
                        </div>
                        </div>
                        <div class="card">
                        {{-- <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Where does it come from?</h4>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            <p>By accepting the terms and conditions, you concede that Devsinc will use the information in countries where it operates. Also, acknowledging our policies proves that you understand the policy, including why and how the information will be used. Nevertheless, you should not use the services if you don't want us to gather personal information.</p>
                            <p>Be aware that privacy and other standards will differ between countries. For instance, the rights of authorities to access information can differ from country to country. However, we will transfer the information to those countries that permit us.</p>
                        </div>
                        </div>
                        <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Security</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>We place a high value on security. In general, we adhere to industry standards when it comes to protecting all information gathered during website visits. Hence, we make every effort to keep personal information private; we guarantee complete security. We keep an eye out to prevent security breaches. We never share or sell your personal information. We do not run advertisements, so no information is used to infer your preferences.</p>
                        </div>
                        </div>
                        <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Retention</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Devsinc will retain the information as long as it is vital for policy purposes and until the account is active. However, you can close your Devsinc account if you no longer want us to use your information to provide services.</p>
                            <p>The information retained is used to resolve certain disputes, enforce revenue laws, and enforce our agreements. The log files are retained for a brief period unless used to improve the site's functionality. We are also legally obligated to hold computer-generated data for a longer time.</p>
                        </div>
                        </div>
                        <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Accessible Information</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>There are some examples below of accessible information that include the following:</p>
                            <p>Identifiable information such as (name, password, email, and address book)</p>
                            <p>Email notifications</p>
                            <p>The content, services, relevant settings, communication, and devices.</p>
                            <p>Recently reviewed content</p>
                            <p>Visibility of the personal profile, comments, posts, and shares.</p>
                        </div>
                        </div>
                        <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Changes in Privacy Policy</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>We may change or revise our privacy policies after a specific time. The changes can be done in several aspects, such as (i) posting changes or through services, (ii) sending a message or email about specific changes, or (iii) posting the updates on the platform; thus we reassure you to check the policies regularly.</p>
                        </div>
                        </div>
                        <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Reach Us</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>If you have any queries contact our support team via our help center. 
                                You may also email us at <a href="mailto:waleed.naeem@devsinc.com">waleed.naeem@devsinc.com</a></p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</x-app-layout>
</html>