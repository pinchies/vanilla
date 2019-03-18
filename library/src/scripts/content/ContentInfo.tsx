/**
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import React from "react";
import { IUserFragment } from "@library/@types/api/users";
import { contentInfoClasses } from "@library/content/contentInfoStyles";
import { metasClasses } from "@library/content/meta/metasStyles";
import classNames from "classnames";
import ProfileLink from "@library/navigation/ProfileLink";
import DateTime from "@library/content/DateTime";
import { MetaTag } from "@library/content/meta/MetaTag";
import { MetaText } from "@library/content/meta/MetaText";
import { MetaGroup } from "@library/content/meta/MetaGroup";

interface IProps {
    user: IUserFragment;
    meta?: React.ReactNode;
}

export function ContentInfo(props: IProps) {
    const { user, meta } = props;
    const classesUser = contentInfoClasses();
    return (
        <div className={classNames(classesUser.root)}>
            <ProfileLink className={classesUser.userPhotoContainer} username={user.name}>
                <img alt={user.name} src={user.photoUrl} className={classesUser.userPhoto} />
            </ProfileLink>
            <div className={classesUser.info}>
                <div className={classesUser.nameLine}>
                    <MetaGroup>
                        <MetaText>
                            <ProfileLink username={user.name} className={classNames(classesUser.userName)}>
                                {user.name}
                            </ProfileLink>
                        </MetaText>
                        {user.title && <MetaTag isPrimary={true}>{user.title}</MetaTag>}
                    </MetaGroup>
                </div>
                {meta && <MetaGroup>{meta}</MetaGroup>}
            </div>
        </div>
    );
}
