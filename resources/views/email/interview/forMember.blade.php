<table>
    <tr>
        <th>
            <p>You are included in the group that will conduct the interview.
                Your presence is necessary for further assessment of the interviewee's skills.</p>
            <br>
            <div class="button">
            <!--[if mso]>
            	<v:roundrect xmlns:v="urn:schemas-microsoft-com:vml"
                         xmlns:w="urn:schemas-microsoft-com:office:word"
                         href="{{route('interviews.show',$interview)}}"
                         style="height:30px;v-text-anchor:middle;width:100px;"
                         arcsize="8%" strokecolor="#4A2ACE"
                         fillcolor="#4A2ACE">
                	<w:anchorlock/>
                	<center style="color:#ffffff;font-family:sans-serif;font-size:16px;font-weight:bold;">
                		{{__("Details")}}
                </center>
            </v:roundrect>
<![endif]-->
                <a href="{{route('interviews.show',$interview)}}"
                   style="background-color:#4A2ACE;border:0 solid #4A2ACE;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;font-weight:bold;line-height:30px;text-align:center;text-decoration:none;width:100px;-webkit-text-size-adjust:none;mso-hide:all;">{{__("Details")}}</a>
            </div>
        </th>
        <th class="expander"></th>
    </tr>
</table>