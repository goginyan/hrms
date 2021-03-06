@extends('email.mail')
@section('content')
    <table class="container text-center">
        <tbody>
        <tr>
            <td> <!-- Main email content -->
                <table class="row">
                    <tbody>
                    <tr> <!-- Logo -->
                        <th class="small-12 large-12 columns first last">
                            <table>
                                <tr>
                                    <th>
                                        <center data-parsed="">
                                            <a href="{{route('home')}}" align="center" class="text-center">
                                                <img src="{{$settings->company_logo}}" class="swu-logo"
                                                     alt="Logo Image">
                                            </a>
                                        </center>
                                    </th>
                                    <th class="expander"></th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    </tbody>
                </table>
                <table class="row masthead">
                    <tbody>
                    <tr> <!-- Masthead -->
                        <th class="small-12 large-12 columns first last">
                            <table>
                                <tr>
                                    <th>
                                        <h1 class="text-center">{{__("We have prepared a quiz for you")}}</h1>
                                        <center data-parsed="">
                                            <img src="{{asset('images/mail/main.png')}}"
                                                 valign="bottom" alt="Masthead Image" align="center"
                                                 class="text-center">
                                        </center>
                                    </th>
                                    <th class="expander"></th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    </tbody>
                </table>
                <table class="row">
                    <tbody>
                    <tr> <!--This row adds the whitespace gap between masthead and digest content -->
                        <th class="small-12 large-12 columns first last">
                            <table>
                                <tr>
                                    <th>
                                        &#xA0;
                                    </th>
                                    <th class="expander"></th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    </tbody>
                </table>
                <table class="row">
                    <tbody>
                    <tr> <!-- Main Email content -->
                        <th class="small-12 large-12 columns first last">
                            <table>
                                <tr>
                                    <th>
                                        <p>Follow the link (press the button) to take the quiz</p>
                                        <br>
                                        <div class="button">
                                        <!--[if mso]>
                                            <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml"
                                                         xmlns:w="urn:schemas-microsoft-com:office:word"
                                                         href="{{route('quizzes.public.pass',[$quiz,$token])}}"
                                                         style="height:45px;v-text-anchor:middle;width:150px;"
                                                         arcsize="8%" strokecolor="#4A2ACE"
                                                         fillcolor="#4A2ACE">
                                                <w:anchorlock/>
                                                <center style="color:#ffffff;font-family:sans-serif;font-size:16px;font-weight:bold;">
                                                    {{__("Pass the Quiz")}}
                                            </center>
                                        </v:roundrect>
<![endif]-->
                                            <a href="{{route('quizzes.public.pass',[$quiz,$token])}}"
                                               style="background-color:#4A2ACE;border:0 solid #4A2ACE;border-radius:90px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;font-weight:bold;line-height:45px;text-align:center;text-decoration:none;width:150px;-webkit-text-size-adjust:none;mso-hide:all;">{{__("Pass the Quiz")}}</a>
                                        </div>
                                    </th>
                                    <th class="expander"></th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    </tbody>
                </table>
                <table class="row">
                    <tbody>
                    <tr> <!-- spacer  -->
                        <th class="small-12 large-12 columns first last">
                            <table>
                                <tr>
                                    <th>
                                        <hr>&#xA0;
                                    </th>
                                    <th class="expander"></th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    </tbody>
                </table>
                <table class="row">
                    <tbody>
                    <tr> <!-- Digest Content 2 columns-->
                        <th class="large-offset-1 small-12 large-6 columns first">
                            <table>
                                <tr>
                                    <th>
                                        <h5>{{$quiz->title}}</h5>
                                    </th>
                                </tr>
                            </table>
                        </th>
                        <th class="small-12 large-6 columns last">
                            <table>
                                <tr>
                                    <th>
                                        <h5>{{__("You can pass the quiz only one time")}}</h5>
                                        <p>{{__("We contact with you after you passed the quiz.")}}</p>
                                    </th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    </tbody>
                </table>
                <table class="row">
                    <tbody>
                    <tr> <!-- This container adds the gap between digest content and CTA  -->
                        <th class="small-12 large-12 columns first last">
                            <table>
                                <tr>
                                    <th>
                                        &#xA0;<hr>
                                    </th>
                                    <th class="expander"></th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    </tbody>
                </table>
                <table class="row">
                    <tbody>
                    <tr> <!-- secondary email content -->
                        <th class="small-12 large-12 columns first last">
                            <table>
                                <tr>
                                    <th>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                            enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                            nisi ut aliquip ex ea commodo consequat.</p>

                                    </th>
                                    <th class="expander"></th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    </tbody>
                </table>
                <table class="row">
                    <tbody>
                    <tr> <!-- This container adds the gap between digest content and CTA  -->
                        <th class="small-12 large-12 columns first last">
                            <table>
                                <tr>
                                    <th>
                                        &#xA0;
                                    </th>
                                    <th class="expander"></th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
