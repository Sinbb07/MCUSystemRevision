@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-md border-gray-300']) }}>
    <option value="" disabled selected>-- Choose type of user --</option>
    <option value="Superadmin">Superadmin</option>
    <option value="ERB Admin">ERB Admin</option>
    <option value="IACUC Admin">IACUC Admin</option>
    <option value="ERB Reviewer">ERB Reviewer</option>
    <option value="IACUC Reviewer">IACUC Reviewer</option>
</select>