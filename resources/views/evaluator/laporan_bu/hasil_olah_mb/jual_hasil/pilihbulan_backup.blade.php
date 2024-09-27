<table border="1">
    <tr>
        <th>Test</th>
        <th>Test</th>
        <th>Test</th>
    </tr>
    @for ($i =0 ; $i <5 ; $i++)
     
    <tr>
        <td rowspan = "3">Test</td>
        <td>Test</td>
        <td rowspan = "3">Test</td>
    </tr>
    <tr>
        <td>Test</td>
    </tr>
    <tr>
        <td>Test</td>
    </tr>
       
    @endfor
</table>
