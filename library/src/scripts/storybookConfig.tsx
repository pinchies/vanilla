/**
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import React from "react";
import { addDecorator } from "@storybook/react";
import Backgrounds from "@library/layout/Backgrounds";
import { ThemeProvider } from "@library/theming/ThemeProvider";
import { Provider } from "react-redux";
import getStore from "@library/redux/getStore";
import { ensureScript } from "@library/dom/domUtils";
import "../scss/_base.scss";
import { onReady } from "@library/utility/appUtils";
import { cssRule, forceRenderStyles } from "typestyle";
import { important, px } from "csx";

const errorMessage = "There was an error fetching the theme.";

const Error = () => <p>{errorMessage}</p>;

onReady(() => {
    const styleDecorator = storyFn => {
        return (
            <>
                <Provider store={getStore()}>
                    <ThemeProvider errorComponent={<Error />} themeKey="theme-variables-dark">
                        <div>
                            <Backgrounds />
                            {storyFn()}
                        </div>
                    </ThemeProvider>
                </Provider>
            </>
        );
    };

    addDecorator(styleDecorator);

    void ensureScript("https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js").then(() => {
        window.WebFont.load({
            google: {
                families: ["Open Sans:400,400italic,600,700"], // Will be dynamic at some point
            },
        });
    });
});

cssRule("body", {
    margin: important("24px"),
});
forceRenderStyles();
