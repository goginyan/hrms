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
                                        <h1 class="text-center">{{__("You are invited to an interview")}}</h1>
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
                            @if ($isMember)
                                @include('email.interview.forMember')
                            @else
                                @include('email.interview.forCandidate')
                            @endif
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
                                        <h5>{{$vacancy->position}}</h5>
                                    </th>
                                </tr>
                            </table>
                        </th>
                        <th class="small-12 large-6 columns last">
                            <table>
                                <tr>
                                    <th>
                                        <h5>{{__("Interview Date")}}</h5>
                                        <p>{{$interview->planned_at->format('d.m.Y H:i')}}</p>
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
