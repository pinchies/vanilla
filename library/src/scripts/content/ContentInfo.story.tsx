/**
 * @author Adam Charron <adam.c@vanillaforums.com>
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import React from "react";
import UserContent from "@library/content/UserContent";
import { storiesOf } from "@storybook/react";
import { IUserFragment } from "@library/@types/api/users";
import { ContentInfo } from "@library/content/ContentInfo";
import { MetaGroup } from "@library/content/meta/MetaGroup";
import DateTime from "@library/content/DateTime";
import { MetaText } from "@library/content/meta/MetaText";

const user: IUserFragment = {
    name: "Adam Charron",
    photoUrl: "https://us.v-cdn.net/5018160/uploads/userpics/809/nHZP3CA8JMR2H.jpg",
    userID: 4,
    dateLastActive: "2019-02-10T23:54:14+00:00",
    title: "Vanilla Staff",
};

const meta = (
    <MetaText>
        <DateTime timestamp="2019-02-10T23:54:14+00:00" />
    </MetaText>
);

storiesOf("@library/content/ContentInfo", module).add("All data", () => {
    return <ContentInfo user={user} meta={meta} />;
});
